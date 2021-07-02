<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SignOutController extends Controller
{
    public function signout(Request $request)
    {
        if ($request->post('signout'))
        {
            if (session()->has("user_email"))
            {
                session()->pull("user_email");
                session()->pull("access_token");
                session()->pull("authenticated");

                return array("status" => "ok");      
            }

            else
            {
                return array("status" => "error");    
            }
        }
    }
}
