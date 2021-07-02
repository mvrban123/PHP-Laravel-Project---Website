<?php

namespace App\Http\Controllers\Api\V3;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use App\Models\Korisnik;
use App\Modules\Helpers\TokenHelper\TokenHelper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function request_pwd_reset(Request $request)
    {
        $tokenHelperObj = new TokenHelper();

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

        if ($tokenHelperObj->VerifyToken($tokenValue) == true)
        {
            $POST = $request->post();
            if (isset($POST['email']) && isset($POST['oib']))
            {
                $userRequester = Korisnik::where([
                    ['email', '=', $POST['email']],
                    ['oib', '=', $POST['oib']]
                ])->first();

                if($userRequester)
                {   // stvaram token
                    try {
                        $sig = base64_encode(random_bytes(32));
                    } catch (Exception $e) {
                        http_response_code(500);
                        echo json_encode(
                            array("error" => "Internal error, reset token issue problem")
                        );
                        exit();
                    }

                    $config = (include 'config/config.php');
                    $issuedAt   = time() + 86401; // 24h
                    $expire  = $issuedAt + 86401;
                    $serverName = $config["serverName"];
                    $sub = $POST['email'];

                    $data = [
                        'iat' => $issuedAt,
                        'exp' => $expire,
                        'iss' => $serverName,
                        'data' => [
                            'sub' => $sub,
                            'sig' => $sig
                        ]
                    ];
                    $data = json_encode($data);
                    header('Content-type: application/json');
                    $secretKey = $config['reset']['key'];
                    $algorithm = $config['reset']['algorithm'];

                    try
                    {
                        $resetToken = JWT::encode($data, $secretKey, $algorithm);
                    }
                    catch(Exception $e)
                    {
                        http_response_code(500);
                        echo json_encode(
                            array("error" => "Internal error, reset token issue problem")
                        );
                        exit();
                    }

                    $hashedSig = Hash::make(
                        $sig . $issuedAt
                    );

                    Korisnik::where([
                        ['email', '=', $POST['email']],
                        ['oib', '=', $POST['oib']]
                    ])->update([
                        'pwd_reset_sig' => $hashedSig,
                        'pwd_reset_used' => 0
                    ]);

                    // izgradi reset URL
                    $resetToken = $resetToken;
                    $data = [
                        'resetToken' => $resetToken,
                    ];

                    http_response_code(200);
                    $data = json_encode(array("data" => $data));
                    echo $data;
                }
                else
                {
                    http_response_code(404);
                    echo json_encode(
                        array("error" => "Unknown e-mail and/or OIB.")
                    );
                }
            } 
            else
            {
                http_response_code(400);
                echo json_encode(
                    array("error" => "Missing or wrong parameters.")
                );
            }
        }
        else
        {
            http_response_code(403);
            echo json_encode(
                array("error" => "Unauthorized request. Token mismatch.")
            );
        }

    }


    public function auth_pwd_reset_request(Request $request)
    {
        $tokenHelperObj = new TokenHelper();

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
        if ($tokenHelperObj->VerifyToken($tokenValue) == true)
        {
            $resetToken = $request->post('resetToken');
            $token = htmlspecialchars(strip_tags($resetToken));
        
            $config = (include 'config/config.php');
            $secretKey = $config['reset']['key'];
            $algorithm = $config['reset']['algorithm'];
        
            try{
                $jwt = JWT::decode($token, $secretKey, array($algorithm));
            }
            catch(Exception $e){
                http_response_code(400);
                echo json_encode(
                    array("error" => "Bad reset token value.")
                );
                exit();
            }
        
            $jwt = json_decode($jwt);
            
            $targetEmail = $jwt->data->sub;

            if(Korisnik::where([
                ['email', '=', $targetEmail],
                ['pwd_reset_used', '=', 0]
            ])->first())
            {
                http_response_code(200);
                $data = json_encode(array("user" => $targetEmail));
                echo $data;
            }
            else
            {
                http_response_code(404);
                echo json_encode(
                    array("error" => "Password reset requested for an unexisting user or password reset request not valid.")
                );
                exit();
            }
        }
        else
        {
            http_response_code(403);
            echo json_encode(
                array("error" => "Unauthorized request. Token mismatch.")
            );
            exit();
        }
    }


    public function reset_pwd(Request $request)
    {
        $tokenHelperObj = new TokenHelper();

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
        if ($tokenHelperObj->VerifyToken($tokenValue) == true)
        {
            $POST = $request->post();
            if (
                isset($POST['resetToken'])
                && isset($POST['email'])
                && isset($POST['oib']) 
                && isset($POST['password']) 
            )
            {
                $token = htmlspecialchars(strip_tags($POST['resetToken']));
        
                $config = (include 'config/config.php');
                $secretKey = $config['reset']['key'];
                $algorithm = $config['reset']['algorithm'];
            
                try{
                    $jwt = JWT::decode($token, $secretKey, array($algorithm));
                }
                catch(Exception $e){
                    http_response_code(405);
                    echo json_encode(
                        array("error" => "Bad reset token value.")
                    );
                    exit();
                }
            
                $jwt = json_decode($jwt);

                if(!(time() > $jwt->exp))
                {
                    $korisnik = Korisnik::where([
                        ['email', '=', $POST['email']],
                        ['oib', '=', $POST['oib']]
                    ])->first();

                    if($korisnik)
                    {
                        if(!$korisnik->pwd_reset_used)
                        {
                            $korisnik->pwd_reset_used = 1;
                            $korisnik->save();

                            $tokenSig = $jwt->data->sig . $jwt->iat;
                            if (Hash::check($tokenSig, $korisnik->pwd_reset_sig)) {
                                // stvori i zapiši hash nove lozinke

                                $korisnik->lozinka_s1 = sha1($POST['password']);

                                $korisnik->lozinka_a2 = Hash::make(
                                    $POST['password']
                                );

                                $korisnik->pwd_reset_sig = "";

                                if($korisnik->save())
                                {
                                    // TODO: provjere kod spremanja promijena u BP i na drugim mjestima

                                    http_response_code(200);
                                    echo json_encode(
                                        array("ok" => "Password successfully changed.")
                                    );
                                    exit();
                                }
                                else
                                {
                                    http_response_code(500);
                                    echo json_encode(
                                        array("error" => "Internal error, database problem")
                                    );
                                    exit();
                                }
                            }
                            else
                            {
                                http_response_code(409);
                                echo json_encode(
                                    array("error" => "Bad reset token signature.")
                                );
                                exit();
                            }

                        }
                        else
                        {
                            http_response_code(408);
                            echo json_encode(
                                array("error" => "This reset token has already been used.")
                            );
                            exit();
                        }
                    }
                    else
                    {
                        http_response_code(407);
                        echo json_encode(
                            array("error" => "Password reset requested for an unexisting user.")
                        );
                        exit();
                    }
                }
                else
                {
                    http_response_code(406);
                    echo json_encode(
                        array("error" => "Reset token expired.")
                    );
                    exit();
                }

            }
            else
            {
                http_response_code(400);
                echo json_encode(
                    array("error" => "Missing or wrong parameters.")
                );
                exit();
            }
        }
        else
        {
            http_response_code(403);
            echo json_encode(
                array("error" => "Unauthorized request. Token mismatch.")
            );
            exit();
        }
    }
}