<?php

namespace App\Http\Controllers\Api\V3;

use Illuminate\Http\Request;
use App\Models\Korisnik;
use App\Modules\Helpers\TokenHelper\TokenHelper;
use App\Http\Controllers\Controller;
use Exception;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Hash;

/*
PLANIRANO:

	a) Provjeri ispravnost tokena
		- AKO ISPRAVAN
			1) provjeri user-a
				- AKO ISPRAVAN
					PREUSMJERI HOME
				- AKO NEMA USERA
					ZABILJEŽI USER-a U TOKEN I VRATI TOKEN S USEROM
				- INAČE (NEISPRAVAN USER)
					JAVI OBAVIJEST DA USER NE POSTOJI
					
        - INAČE
            (TREBA LI LOGIN MOĆI PRIMITI PARTNERA?)
			REDIRECT NA AUTH
				- AKO OK
					LOGIRAJ USER-a, DODAJ GA U TOKEN, VRATI TOKEN
				- INAČE
					ISPIŠI GREŠKU



TRENUTNO:

	a) Provjeri ispravnost tokena
		- AKO ISPRAVAN
			ULOGIRAJ USERA
				AKO ISPRAVNO
					ZABILJEŽI USERA
					VRATI AUTENTIFICIRANI TOKEN
				INAČE
					VRATI ERROR
				
		- INAČE
			ISPIŠI GREŠKU
*/

class LoginController extends Controller
{
    private $tokenHelperObj = null;

    public function login_user(Request $request){
        $this->tokenHelperObj = new TokenHelper();

        if(!$request->hasHeader('Authorization')){
            http_response_code(401);
            echo json_encode(
                array("error" => "Unauthorized request. Bearer token missing in header.")
            );
            exit();
        }

        $authorizationArray = explode(" ", $request->header('Authorization'));
        if(count($authorizationArray) !=2 || $authorizationArray[0] != "Bearer"){
            http_response_code(402);
            echo json_encode(
                array("error" => "Unauthorized request. Bearer token incorrect format.")
            );
            exit();
        }

        $tokenValue = $authorizationArray[1];
        $POST = $request->post();
    
        if (
            ( isset($POST['email']) || isset($POST['oib']) ) 
            && isset($POST['password'])
        )
        {
            if (isset($POST['email']))
            {
                $userIdentifierKey = 'email';
            }
            else 
            {
                $userIdentifierKey = 'oib';
            }

            if ($this->tokenHelperObj->VerifyToken($tokenValue) == true)
            {
                // PROVJERA SA STAROM I NOVOM VERZIJOM HASHA LOZINKE
                try
                {
                    $passwordHash = sha1($POST['password']);
                    $result = Korisnik::where([
                        [$userIdentifierKey, '=', $POST[$userIdentifierKey]],
                        ['lozinka_s1', '=', $passwordHash]
                    ])->first();
                }
                catch(Exception $e)
                {
                    $result = Korisnik::where([
                        [$userIdentifierKey, '=', $_POST[$userIdentifierKey]]
                    ])->first();
                    
                    if($result)
                    {
                        if (!Hash::check($POST['password'], $result->lozinka_a2)) {
                            $result = null;
                        }
                    }
                }

                if($result)
                {
                    $token = $this->tokenHelperObj->RecordUser(
                        $result->email, $tokenValue
                    );

                    $token = $this->tokenHelperObj->RenewInactivity($token);

                    $data = $this->tokenHelperObj->ConstructTokenResponseData(
                        $token
                    );

                    if(!$data)
                    {
                        http_response_code(500);
                        echo json_encode(
                            array("error" => "Internal error, token issue problem")
                        );
                        exit();
                    }

                    $date = new DateTime();
                    http_response_code(($date->getTimestamp() >= time()) ? 200 : 201);
                    echo $data;
                }

                else
                {
                    http_response_code(404);
                    echo json_encode(
                        array("error" => "Unknown email, oib or password.")
                    );
                }
            }

            else{
                http_response_code(403);
                echo json_encode(
                    array("error" => "Unauthorized request. Token mismatch.")
                );
            }
        }

        else{
            http_response_code(400);
            echo json_encode(
                array("error" => "Missing or wrong parameters.")
            );
        }	
        
        function get_date()
        {
            $date = new DateTime("now", new DateTimeZone('Europe/Zagreb') );
            return $date->format('Y-m-d H:i:s');
        }
    }   
}
