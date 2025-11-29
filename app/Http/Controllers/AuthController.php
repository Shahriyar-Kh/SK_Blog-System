<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



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

}
}