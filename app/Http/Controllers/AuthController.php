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
    $data=array(
        'name'=>$user->name,
        'actionLink'=>$actionLink
    );
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

}