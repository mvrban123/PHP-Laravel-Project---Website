<?php

namespace App\Http\Controllers;

use App\Models\Korisnik;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class LoginController extends Controller
{
    public function index()
    {
        return view ('login');
    }

    public function login()
    {
        /*
            TOK:
            1.) - AKO: u kolačiču klijenta postoji OAUTH token, 
                    1.) učitavam OAUTH KOLAČIĆ
                    2.) šaljem zahtjev na LoginController APIv3 sa korisnikovim kredencijama

                    AKO JE ODGOVOR POTVRDAN:
                        3.) Spremam nadograđeni OAUTH token u kolačić klijenta
                        4.) Otvaram korisnikovu sesiju
                        5.) Preusmjeravm korisnika na početnu stranicu

                    INAČE:
                        3.) Ispisujem korisniku poruku o neuspjehu

                - INAČE: 
                    1.) šaljem zahtjev na AuthController APIv3
                    2.) Spremam dobiveni OAUTH token u kolačić klijenta
                    3.) šaljem zahtjev na LoginController APIv3 sa korisnikovim kredencijama
                    
                    AKO JE ODGOVOR POTVRDAN:
                        4.) Spremam nadograđeni OAUTH token u kolačić klijenta
                        5.) Otvaram korisnikovu sesiju
                        6.) Preusmjeravm korisnika na početnu stranicu

                    INAČE:
                        4.) Ispisujem korisniku poruku o neuspjehu

        */

        if(isset($_COOKIE["o3p_auth_token"])) {
            return $this->perform_login();
        }

        else {
            if ($this->perform_client_authentification() === true)
            {
                return $this->perform_login();
            }

            else {
                session()->flash('error', "Došlo je do pogreške prilikom autentifikacije klijenta.");
                return view('login');
            }
        }
    }


    private function perform_client_authentification()
    {
        $request_result = $this->request_authentification_token();

        if(isset($request_result))
        {
            if(isset($request_result['error'])){
                // VRATI PORUKU POGREŠKE
                return false;
            }

            elseif(isset($request_result['data'])) {
                setcookie(
                    "o3p_auth_token", serialize($request_result['data']), 
                    time() + 31104000, "/"
                );

                return true;
            }

            else {
                // VRATI PORUKU POGREŠKE
                return view('login');
            }
        }

        else {
            return view('login');
        }
    }


    private function request_authentification_token()
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
        curl_close($ch);

        return $result;
    }


    private function perform_login() {
        $auth_token = unserialize($_COOKIE["o3p_auth_token"])['access_token'];

        $POST_PARAMS = Null;

        if(isset($_POST['loginoib']))
        {
            $POST_PARAMS['oib'] = $_POST['loginoib'];
        }

        if(isset($_POST['loginemail']))
        {
            $POST_PARAMS['email'] = $_POST['loginemail'];
        }

        if(isset($_POST['loginPassword']))
        {
            $POST_PARAMS['password'] = $_POST['loginPassword'];
        }

        $request_result = $this->request_login_access(
            $POST_PARAMS, $auth_token
        );

        if(isset($request_result))
        {
            if (isset($request_result['error'])) {
                // VRATI PORUKU POGREŠKE
                return $request_result['error'];
            }

            elseif (isset($request_result['data'])){
                setcookie(
                    "o3p_auth_token", serialize($request_result['data']), 
                    time() + 31104000, "/"
                );
              
                $this->set_user_session(
                    $request_result['data']['access_token']
                );
                
                return redirect()->intended('admin/dashboard');
            }

            else {
                session()->flash('error', $request_result['error']);
                return view('login');
            }
        }

        else {
            session()->flash('error', $request_result['error']);
            return view('login');
        }
    }


    private function request_login_access($POST_PARAMS, $AUTH_TOKEN)
    {
        $LOGIN_URL = env('APP_DEV_URL') . "/api/v3/login.php";

        $ch = curl_init($LOGIN_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $POST_PARAMS);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            // 'Content-Type: application/json',
            'Authorization: Bearer ' . $AUTH_TOKEN
        ));

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $result;
    }

    private function set_user_session($access_token) {
        session(['authenticated' => time()]);
        session(['access_token' => $access_token]);
        session(['user_email' => $_POST['loginemail']]);
        session()->flash('success', "Uspješna prijava korisnika.");
        // $sveFunkcionalnosti=UserAccessController::getNazivFunkcionalnostiByUloga(1);
        // session(['listaStranica' => $sveFunkcionalnosti]);
    }


    public function login_old()
    {
        // $API_AUTH_URL = "https://vbguest2.com/api/v2/authenticate.php";
        /*
        $API_AUTH_URL = env('APP_DEV_URL') . "/api/v2/authenticate.php";
        $_POST['partner'] = "webapp";// request('username');
        $_POST['password'] = "Y'bItfwHQ5hgcS((jn7>5W|?3";//request('password');
        */

        $_POST['partner'] = 'mobile';
        $_POST['password'] = 'MZ6@ZuH&iXH$$M8RW3F7';
        $API_AUTH_URL = "https://obitelji3plus.hr/api/v1/authenticate.php";
        $ch = curl_init($API_AUTH_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  //maknuti na produkciji
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  // maknuti na produkciji
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);
        
        //dd($result);
        
        //todo napravi provjeru usera
        /*
        $LOGIN_URL = "https://obitelji3plus.hr/api/v1/authenticate.php";
        $ch2 = curl_init($LOGIN_URL);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $_POST);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        $rezultat = json_decode(curl_exec($ch2), true);
        curl_close($ch2);
        */
        
        //todo napravi jos jednu listu koja šalje i naslove stranice vjerojatno jos jedan if za usera
        if (isset($result['data'])) {
            session(['authenticated' => time()]);
            session(['access_token' => $result['data']['access_token']]);
            session()->flash('success', "Uspješna prijava korisnika.");
            session(['uloga' => '1']);
            session(['korisnik' => '1']);
            $sveFunkcionalnosti=UserAccessController::getNazivFunkcionalnostiByUloga(1);
            session(['listaStranica' => $sveFunkcionalnosti]);
            return redirect()->intended('admin/dashboard');
        }
        session()->flash('error', $result['error']);
        return view('login');
    }
}