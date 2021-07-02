<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //session()->flash('success', "Dobrodošli.");
        return view("dashboard");
    }
}
