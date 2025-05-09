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
<<<<<<< HEAD
        return view('dashboard.index');
=======
        return view('dashboard.index',compact('users'));
>>>>>>> refs/remotes/origin/main
    }
}
