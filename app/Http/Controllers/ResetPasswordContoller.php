<?php

namespace App\Http\Controllers;

use App\Models\Korisnik;
use App\Modules\Helpers\BaseAutoPorukeJobHelper;
use App\Jobs\PasswordResetRequestJob;
use Illuminate\Http\Request;

class ResetPasswordContoller extends Controller
{
    public function set_new_pwd(Request $request)
    {
        // TODO MAKNUTI ZA PROD. KADA SE IMPLEMENTIRA SLANJE TOKENA
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.IntcImlhdFwiOjE2MTI5ODc1NzMsXCJqdGlcIjpcIlcrXFxcL3gydldnZ3I0Wnl4c2psUitvZFZhZ05ZZmRuZFk2Rlp4RXNHbWpMT0U9XCIsXCJpc3NcIjpcIm9iaXRlbGppM3BsdXMuaHJcIixcIm5iZlwiOjE2MTI5ODc1NzQsXCJleHBcIjoxNjQ0MDkxNTc0LFwicGFydG5lclwiOlwid2ViYXBwXCJ9Ig.PDatSBbKY_AqVhI-4NDRq9loOpof6rVsOflIZXgycIC6Hem2TAvlnX6aWzVavWy4rx2uwFQQRCDQbAoL9olc3Q';

        $API_URL = env('APP_DEV_URL') . "/api/v3/reset-pwd.php";
        $POST['resetToken'] = $request->post('resetToken');
        $POST['email'] = $request->post('email');
        $POST['oib'] = $request->post('oib');
        $POST['password'] = $request->post('password');

        $ch = curl_init($API_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);

        // TODO MAKNUTI NA PROD
        // TODO TREBA IZ REQUESTA UZIMATI Bearer Token HEADER
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

        setcookie("reset_url", "", time()-3600);

        if (isset($rezultat['error'])) {
            echo json_encode(array(
                "status" => "error",
                "message" => $rezultat['error'] 
            ));
        }
        else
        {
            echo json_encode(array("status" => "ok",));
        }
    }

    public function reset_pwd(Request $request, $url)
    {
        $error = false;

        // TODO MAKNUTI ZA PROD. KADA SE IMPLEMENTIRA SLANJE TOKENA
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.IntcImlhdFwiOjE2MTI5ODc1NzMsXCJqdGlcIjpcIlcrXFxcL3gydldnZ3I0Wnl4c2psUitvZFZhZ05ZZmRuZFk2Rlp4RXNHbWpMT0U9XCIsXCJpc3NcIjpcIm9iaXRlbGppM3BsdXMuaHJcIixcIm5iZlwiOjE2MTI5ODc1NzQsXCJleHBcIjoxNjQ0MDkxNTc0LFwicGFydG5lclwiOlwid2ViYXBwXCJ9Ig.PDatSBbKY_AqVhI-4NDRq9loOpof6rVsOflIZXgycIC6Hem2TAvlnX6aWzVavWy4rx2uwFQQRCDQbAoL9olc3Q';

        $API_URL = env('APP_DEV_URL') . "/api/v3/auth-pwd-reset-request.php";
        $POST['resetToken'] = $url;
        $ch = curl_init($API_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);

        // TODO MAKNUTI NA PROD
        // TODO TREBA IZ REQUESTA UZIMATI Bearer Token HEADER
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

        if (isset($rezultat['error'])) {
            $error = true;
        }
        else
        {
            setcookie("reset_url", $url, time()+3600);
        }

        return view('pwdreset', ['error' => $error]);
    }

    public function request_reset_pwd(Request $request)
        {
            // $POST = $request->post();
            
            // // TODO poziv reset apiju
            // $data = json_encode(array("status" => "ok"));
            // return $data;

            /* TODO: MAKNUTI
                test data
                email: cigvuahe@jejzis.af
                oib: 12345678901
            */

            // TODO MAKNUTI ZA PROD. KADA SE IMPLEMENTIRA SLANJE TOKENA
            $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.IntcImlhdFwiOjE2MTI5ODc1NzMsXCJqdGlcIjpcIlcrXFxcL3gydldnZ3I0Wnl4c2psUitvZFZhZ05ZZmRuZFk2Rlp4RXNHbWpMT0U9XCIsXCJpc3NcIjpcIm9iaXRlbGppM3BsdXMuaHJcIixcIm5iZlwiOjE2MTI5ODc1NzQsXCJleHBcIjoxNjQ0MDkxNTc0LFwicGFydG5lclwiOlwid2ViYXBwXCJ9Ig.PDatSBbKY_AqVhI-4NDRq9loOpof6rVsOflIZXgycIC6Hem2TAvlnX6aWzVavWy4rx2uwFQQRCDQbAoL9olc3Q';


            $API_URL = env('APP_DEV_URL') . "/api/v3/request-pwd-reset.php";
            $POST['email'] = $request->post('email');
            $POST['oib'] = $request->post('oib');
            $ch = curl_init($API_URL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
    
            // TODO MAKNUTI NA PROD
            // TODO TREBA IZ REQUESTA UZIMATI Bearer Token HEADER
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

            if (isset($rezultat['error'])) {
                echo json_encode(
                    array(
                        "status" => "error",
                        "message" => $rezultat['error']
                    )
                );
            }
            else
            {

                $RESET_PWD_URL = env('APP_DEV_URL') . "/reset-pwd/reset/" . $rezultat['data']['resetToken'];

                $jobHelperObj = new BaseAutoPorukeJobHelper(
                    "promjena_lozinke"
                );

                $job = new PasswordResetRequestJob();

                $jobHelperObj->dispatchJob(
                    $job,
                    array(
                        // TODO POSLATI NA ISPRAVNU MAIL ADRESU
                        // 'email' => $POST['email'],
                        'email' => 'geropin804@timothyjsilverman.com',
                        'url'  => $RESET_PWD_URL
                    )
                );
                echo json_encode(array("status" => "ok",));
            }
        }
}