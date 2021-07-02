<?php

namespace App\Http\Controllers\Api\V3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestLoginController extends Controller
{
    public function test(){
        /* PRIMJER CIJELOG TOKENA (webapp)
            array (size=1)
            'data' => 
                array (size=4)
                'access_token' => string 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.IntcImlhdFwiOjE2MTI5ODc1NzMsXCJqdGlcIjpcIlcrXFxcL3gydldnZ3I0Wnl4c2psUitvZFZhZ05ZZmRuZFk2Rlp4RXNHbWpMT0U9XCIsXCJpc3NcIjpcIm9iaXRlbGppM3BsdXMuaHJcIixcIm5iZlwiOjE2MTI5ODc1NzQsXCJleHBcIjoxNjQ0MDkxNTc0LFwicGFydG5lclwiOlwid2ViYXBwXCJ9Ig.PDatSBbKY_AqVhI-4NDRq9loOpof6rVsOflIZXgycIC6Hem2TAvlnX6aWzVavWy4rx2uwFQQRCDQbAoL9olc3Q' (length=354)
                'expires_in' => int 1644091574
                'issued' => string '10 Feb 2021 21:06:13' (length=20)
                'expires' => string '05 Feb 2022 21:06:14' (length=20)
        */
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.IntcImlhdFwiOjE2MTI5ODc1NzMsXCJqdGlcIjpcIlcrXFxcL3gydldnZ3I0Wnl4c2psUitvZFZhZ05ZZmRuZFk2Rlp4RXNHbWpMT0U9XCIsXCJpc3NcIjpcIm9iaXRlbGppM3BsdXMuaHJcIixcIm5iZlwiOjE2MTI5ODc1NzQsXCJleHBcIjoxNjQ0MDkxNTc0LFwicGFydG5lclwiOlwid2ViYXBwXCJ9Ig.PDatSBbKY_AqVhI-4NDRq9loOpof6rVsOflIZXgycIC6Hem2TAvlnX6aWzVavWy4rx2uwFQQRCDQbAoL9olc3Q';

        // $POST['email'] = "cigvuahe@jejzis.af";// request('email');
        $POST['oib'] = "12345678901";// request('oib');
        // email = "cigvuahe@jejzis.af"
        $POST['password'] = "moja_lozinka";//request('password');
        
        // $LOGIN_URL = "https://vbguest2.com/api/v2/login.php";
        $LOGIN_URL = env('APP_DEV_URL') . "/api/v3/login.php";

        $ch = curl_init($LOGIN_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            // 'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        
        $rezultat = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (isset($rezultat)) {
            echo"POG MAKSIMUS";
            echo isset($rezultat['error']);
            //kreiraj sesije za korisnika
        }

        return var_dump($rezultat);        
    }   
}
