<?php

namespace App\Http\Controllers\DbControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailPredlozak;

class EmailPredlozakController extends Controller
{
    public static function readAll(){
        $sviPredlosci = EmailPredlozak::all();
        return $sviPredlosci;
    }
    
}
