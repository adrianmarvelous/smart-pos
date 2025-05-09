<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::with('modelHasRoles.hasRole')->get();
        // dd($users);
        return view('dashboard.index');
    }
}
