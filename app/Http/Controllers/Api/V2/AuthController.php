<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Firebase\JWT\JWT;
use App\Models\PristupniKlijenti;
use Exception;
#require_once 'objects/partner.php';
#require_once('misc2.php');
#require_once('vendor/autoload.php');
#require_once('vendor/firebase/phpjwt/src/JWT.php');

class AuthController extends Controller
{
    public function test(Request $request)
    {
        $a =json_encode(
            $request->post()
        );

        echo json_encode(
            $request->post()
        );
        exit(); 
    }

    public function authenticate_client(Request $request)
    {
        // http_response_code(500);
        // echo json_encode(
        //     array("error" => "Authentication problem! Access forbidden to this user!")
        // );
        // exit();
        $POST = $request->post();

        if(isset($POST['partner']) && isset($POST['password']))
        {
            $result = PristupniKlijenti::where([
                ['naziv_unq', '=', $POST['partner']],
                ['lozinka', '=', $POST['password']],
            ])->get();

            if(!$result){
                http_response_code(500);
                echo json_encode(
                    array("error" => "Authentication problem! Invalid credentials!")
                );
                exit();
            }

            else
            {
                foreach ($result as $partner) {
                    $deletedAt = $partner->deleted_at;
                }

                if(!is_null($deletedAt))
                {
                    http_response_code(500);
                    echo json_encode(
                        array("error" => "Authentication problem! Access forbidden to this user!")
                    );
                    exit();   
                }
            }

            if(function_exists('random_bytes'))
            {
                try {
                    $tokenId = base64_encode(random_bytes(32));
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(
                        array("error" => "Internal error, token issue problem")
                    );
                    exit();
                }
            }

            if (function_exists('mcrypt_create_iv')) {
                // alternativa za mcrypt_create_iv je random_bytes()
                $tokenId = base64_encode(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
            }
            
            $config = (include 'config/config.php');
            //random token id
            $issuedAt   = time();
            $notBefore  = $issuedAt+1;
            $expire     = $notBefore + 31104000;            // 1 year
            $serverName = $config["serverName"];
            
            $data = [
                'iat'  => $issuedAt,         // Issued at: time when the token was generated
                'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
                'iss'  => $serverName,       // Issuer
                'nbf'  => $notBefore,        // Not before
                'exp'  => $expire,           // Expire
                'partner' => $result[0]->naziv_unq,	     // User name
                'api' => '2'
            ];
            $data = json_encode($data);
            header('Content-type: application/json');
            $secretKey = $config['jwt']['key'];
            $algorithm = $config['jwt']['algorithm'];

            try
            {
                $jwt = JWT::encode($data, $secretKey, $algorithm);
            }
            
            catch(Exception $e)
            {
                http_response_code(500);
                echo json_encode(
                    array("error" => "Internal error, token issue problem")
                );
                exit();
            }
            
            $data = [
                'access_token' => $jwt,
                'expires_in' => $expire,
                'issued' => date("d M Y H:i:s", $issuedAt),
                'expires' => date("d M Y H:i:s", $expire)
            ];
            
            http_response_code(200);
            $data = json_encode(array("data" => $data));
            echo $data;
        }

        else
        {
            http_response_code(400);
            echo json_encode(
                array("error" => "Missing parameters")
            );
        }
    }
}
