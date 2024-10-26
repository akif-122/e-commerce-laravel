<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    function index(){
        return view("admin.dashboard");
    }

    function logout(){
        Auth::guard("admin")->logout();

        return redirect()->route("admin.login");
    }
}
