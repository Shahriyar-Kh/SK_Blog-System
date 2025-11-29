<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //admin dashboard method
    public function adminDashboard(Request $request){
        $data = [
            'PageTitle' => 'Admin Dashboard',
        ];
        return view('back.pages.dashboard', $data);
    }


    // admin logout method
    public function adminLogout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login') ->with('success', 'You have been logged out successfully.');
    } 
}