<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    //

    function index()
    {

        return view("admin.login");
    }

    function authenticate(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);

        if ($validator->passes()) {
            if (Auth::guard("admin")->attempt(["email" => $req->email, "password" => $req->password], $req->get("remember"))) {
                $admin = Auth::guard("admin")->user();

                if ($admin->role == 2) {

                    return redirect()->route("admin.dashboard");
                } else {
                    Auth::guard("admin")->logout();
                    return redirect()->route("admin.login")->with("warning", "You are not authorized to acces admin panel.");
                }
            } else {
                return redirect()->route("admin.login")->with("error", "Email or Password is Inccorrect!");
            }
        } else {
            return redirect()->back()->withInput($req->only("email"))->withErrors($validator);
        }
    }
}
