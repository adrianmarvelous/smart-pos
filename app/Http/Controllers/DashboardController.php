<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::with('modelHasRoles.hasRole')->where('id',session('user_id'))->first();
        // dd($users);
        return view('dashboard.dashboard',compact('user'));
    }
}
