<?php

namespace App\Http\Controllers\Api\V3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestAuthController extends Controller
{
    public function test()
    {
        // $API_AUTH_URL = "https://vbguest2.com/api/v2/authenticate.php";
        $API_AUTH_URL = env('APP_DEV_URL') . "/api/v3/authenticate.php";
        $_POST['partner'] = "webapp";// request('username');
        $_POST['password'] = "Y'bItfwHQ5hgcS((jn7>5W|?3";//request('password');
    
        $ch = curl_init($API_AUTH_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $pre = curl_exec($ch);
        $result = json_decode(curl_exec($ch), true);

        if (curl_errno($ch)) { 
            print curl_error($ch); 
        } 
        curl_close($ch);

        var_dump(
            $result
        );
    }
}
