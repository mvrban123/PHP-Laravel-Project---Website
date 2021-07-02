<?php
require_once('vendor/autoload.php');
require_once('vendor/firebase/phpjwt/src/JWT.php');

use App\Models\PristupniKlijenti;
use \Firebase\JWT\JWT;

function Error($errNumber, $message = "")
{
	//errNumber moze biti 400, 404, 409, 500, 501
	header('Content-type: application/json');
	http_response_code($errNumber);
	echo json_encode(array("status"=>$errNumber,"message"=>$message));
}


function VerifyToken($token)
{
	$jwt = DecodeToken($token);

	$partner =  $jwt->partner;

	$result = PristupniKlijenti::where('naziv_unq',$partner)->first();

	if($result && $jwt->iss == 'obitelji3plus.hr' && ($jwt->exp > time()))
		return true;
	else
		return false;	
}

function RecordUser($userEmail, $token)
{
	$jwt = null;
	if(VerifyToken($token))
	{
		$jwt = DecodeToken($token);
		$jwt->sub= $userEmail;
		$jwt = EncodeToken($jwt);
	}

	return $jwt;
}


function EncodeToken($token)
{
	$config = (include 'config/config.php');
	$secretKey = $config['jwt']['key'];
	$algorithm = $config['jwt']['algorithm'];
	
	try
	{
		$jwt = JWT::encode($token, $secretKey, $algorithm);
	}
	
	catch(Exception $e)
	{
		return null;
	}

	$data = [
		"status" => "OK", 
		'access_token' => $jwt,
		'expires_in' => $token->exp,
		'issued' => date("d M Y H:i:s", $token->iat),
		'expires' => date("d M Y H:i:s", $token->exp)
	];

	$data = json_encode(array("data" => $data));
	return $data;
}


function DecodeToken($token)
{
	$token = htmlspecialchars(strip_tags($token));
	
	$config = (include 'config/config.php');
	$secretKey = $config['jwt']['key'];
	$algorithm = $config['jwt']['algorithm'];

	try{
		$jwt = JWT::decode($token, $secretKey, array($algorithm));
	}
	catch(Exception $e){
		return false;
	}

	$jwt = json_decode($jwt);

	return $jwt;
}


function GetTime()
{
	return date('Y-m-d H:i:s');
}


if (!function_exists('getallheaders')) {
	function getallheaders() {
		$headers = [];
		foreach ($_SERVER as $name => $value) {
			if (substr($name, 0, 5) == 'HTTP_') {
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
		return $headers;
	}
}
