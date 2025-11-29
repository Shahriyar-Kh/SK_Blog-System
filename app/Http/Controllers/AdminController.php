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
}
