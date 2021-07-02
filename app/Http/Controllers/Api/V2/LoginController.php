<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Models\Korisnik;
use App\Http\Controllers\Controller;
use Exception;
use DateInterval;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Null_;

class LoginController extends Controller
{
    public function login_user(Request $request){
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
    
        if (isset($POST['user_name']) && isset($POST['password'])){
            require_once('misc.php');
            if (VerifyToken($tokenValue) == true)
            {

                // PROVJERA SA STAROM I NOVOM VERZIJOM HASHA LOZINKE
                try
                {
                    $userName = $POST['user_name'];
                    $passwordHash = sha1($POST['password']);
                    $result = Korisnik::where([
                        ['korisnicko_ime', '=', $userName],
                        ['lozinka_s1', '=', $passwordHash]
                    ])->first();
                }
                catch(Exception $e)
                {
                    $result = Korisnik::where([
                        ['korisnicko_ime', '=', $_POST['user_name']]
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
                    //$row = $result->fetch(PDO::FETCH_ASSOC);
                    //extract($row);
                    //$date = date_create($valid_to); //echo date_format($date, 'd.m.Y.');
                    $date = date_create("2021-03-15");
                    $date->add(new DateInterval('P1D'));
                    $user_data = 
                    [
                        'user_name'=> $result['korisnicko_ime'],
                        'valid_to'=> $date,
                        //'card'=> $card
                        'user_id'=>$result['id']
                    ];
    
                    http_response_code(($date->getTimestamp() >= time()) ? 200 : 201);
                    echo json_encode(
                        array(
                            "status" => "OK", 
                            "card_valid" => ($date->getTimestamp() >= time()), 
                            "user_data" => $user_data
                            )
                    );
                }

                else
                {
                    http_response_code(404);
                    echo json_encode(
                        array("error" => "Unknown username or password.")
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
