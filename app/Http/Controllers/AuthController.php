<?php

namespace App\Http\Controllers;

use App\Helpers\CMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon; 



class AuthController extends Controller
{
    // create a method to handle user login
    public function loginForm(Request $request)
    {
        $data = [
            'PageTitle' => 'Login Page',
        ];
        return view('back.pages.auth.login', $data);
    }

    // create a method to handle forgotForm
    public function forgotForm(Request $request)
    {
        $data = [
            'PageTitle' => 'Forgot Password',
        ];
        return view('back.pages.auth.forget', $data);
    }

    // create a method to handle login submission
    public function loginHandler(Request $request)
    {
        // find whether the login_id is email or username
      $fieldsType=filter_var($request->login_id,FILTER_VALIDATE_EMAIL)?'email':'username';
      
      if($fieldsType=='email'){
        $request->validate([
            'login_id'=>'required|email|exists:users,email',
            'password'=>'required|string|min:6',

        ],[
            'login_id.required'=>'The email field is required.',
            'login_id.email'=>'The email must be a valid email address.',
            'login_id.exists'=>'No account found with this email.',
        ]);}
        else{
            $request->validate([
                'login_id'=>'required|string|exists:users,username',
                'password'=>'required|string|min:6',
    
            ],[
                'login_id.required'=>'The username field is required.',
                'login_id.exists'=>'No account found with this username.',
            ]);} 

        $credentials = array(
            $fieldsType => $request->login_id,
            'password' => $request->password,
        );
        if (Auth::attempt($credentials)) {
            // check account status
            if (Auth::user()->status == 'Inactive') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with(['fail' => 'Your account is inactive. Please contact support at (support@example.com) for further assistance.']);
            } elseif (Auth::user()->status == 'Pending') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with(['fail' => 'Your account is pending approval. Please wait for an administrator to activate your account.']);
            }

            // redirect user to dashboard
            return redirect()->route('admin.dashboard');
        } else {

            return redirect()->route('admin.login')->withInput()->with(['fail' => 'incorrect password. Please try again.']);
        }

}//end loginHandler

// method for reset password Link
public function sendPasswordResetLink(Request $request)
{
    // validate email
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ],[
        'email.required'=>'The email field is required.',
        'email.email'=>'The email must be a valid email address.',
        'email.exists'=>'No account found with this email.',
    ]);
    // get user details
    $user = User::where('email', $request->email)->first();
    // create password reset token
    $token = base64_encode(Str::random(60));

    //check if token already exists for this email, if yes then update it
    $existingToken = DB::table('password_reset_tokens')->where('email', $user->email)->first();

    if ($existingToken) {
        // update existing token
        DB::table('password_reset_tokens')
        ->where('email', $user->email)
        ->update([
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
    } else {
        // insert new token
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }
    // Create clickable link
    $actionLink=route('admin.reset-password-form',['token'=>$token]);
    $data=[

        'name'=>$user->name,
        'actionLink'=>$actionLink
    ];
    $mail_body=view('components.email-templates.forgot-template',$data)->render();
    $mail_config=array(
        'recipient_address'=>$user->email,
        'recipient_name'=>$user->name,
        'subject'=>'Password Reset Request',
        'body'=>$mail_body
    );
    if (CMail::sendMail($mail_config)) {
        return redirect()->route('admin.forgot-password')->with(['success' => 'We have emailed your password reset link! Please check your email.']);
    } else {
        return redirect()->route('admin.forgot-password')->with(['fail' => 'Unable to send reset link. Please try again later.']);
    }


} //end forgotPasswordLink method
// method to show reset password form
public function resetPasswordForm($token)
{
  // check if token exists
    $tokenData = DB::table('password_reset_tokens')->where('token', $token)->first();  

    if (!$tokenData) {
        return redirect()->route('admin.forgot-password')->with(['fail' => 'Invalid or expired password reset token. Please request a new password reset link.']);
    }
    else{
        // check if token is not expired (valid for 15 minutes)
        $diffMins=Carbon::createFromFormat('Y-m-d H:i:s',$tokenData->created_at)
        ->diffInMinutes(Carbon::now());
        if ($diffMins > 15) {
         return redirect()->route('admin.forgot-password')->with(['fail' => 'Password reset token has expired. Please request a new password reset link.']);
        }
        $data=[
            'PageTitle'=>'Reset Password',
            'token'=>$token
        ];
    }

    // show reset password form
    return view('back.pages.auth.reset-password-form', ['token' => $token]);
}

// method to handle reset password submission
public function resetPasswordHandler(Request $request)
{
    // validate new password
    $request->validate([
        'new_password' => 'required|min:6|required_with:new_password_confirmation|same:new_password_confirmation',
        'new_password_confirmation' => 'required',
    ]);
    // check if token exists
    $tokenData = DB::table('password_reset_tokens')->where('token', $request->token)->first();

    // get user details
    $user = User::where('email', $tokenData->email)->first();

    // update user password
    User::where('email', $user->email)->update([
        'password' => Hash::make($request->new_password)
    ]);

    // send notification email about password change
    $data=[
        'name'=>$user->name,
        'email'=>$user->email,
        'new_password'=>$request->new_password
    ];

    // prepare email
    $mail_body=view('components.email-templates.password-change-template',$data)->render();

    // mail configuration
    $mail_config=array(
        'recipient_address'=>$user->email,
        'recipient_name'=>$user->name,
        'subject'=>'Your Password Has Been Changed',
        'body'=>$mail_body
    );
    
    // send email notification

    if (CMail::sendMail($mail_config)) {
        // delete the token
        DB::table('password_reset_tokens')->where([
            'email' => $tokenData->email,
            'token' => $tokenData->token
            ])->delete();

        return redirect()->route('admin.login')->with(['success' => 'Your password has been successfully reset. You can now log in with your new password.']);
    } else {
        return redirect()->route('admin.reset-password-form', ['token' => $request->token])->with(['fail' => 'Unable to send confirmation email. Please try again later.']);
    }

 }
}