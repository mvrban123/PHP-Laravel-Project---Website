<?php

//error_reporting(E_ALL); // Error engine
//ini_set('display_errors', TRUE); // Error display
//ini_set('log_errors', TRUE); // Error logging
//ini_set('error_log', 'errors.log'); // Logging file
//ini_set('log_errors_max_len', 1024); // Logging file size

use App\Models\Korisnik;

require_once('misc.php');

	if(!isset(getallheaders()["Authorization"])){
		http_response_code(401);
		echo json_encode(
			array("error" => "Unauthorized request. Bearer token missing in header.")
		);
		exit();
	}
	$authorizationArray = explode(" ", getallheaders()["Authorization"]);
	if(count($authorizationArray) !=2 || $authorizationArray[0] != "Bearer"){
		http_response_code(402);
		echo json_encode(
			array("error" => "Unauthorized request. Bearer token incorrect format.")
		);
		exit();
	}
	$tokenValue = $authorizationArray[1];

	if (isset($_POST['user_name_web']) && isset($_POST['loginPassword'])){
		if (VerifyToken($tokenValue) == true)
		{
			/* stari nacin
			require_once 'config/database.php';
			require_once 'objects/user.php';
			
			$database = new Database();
			$db = $database->getConnection();
			
			$user = new User($db);
			$user->email = $_POST['user_name'];
			$user->password = $_POST['password'];
			
			$result = $user->getUserByLogin();
			*/
			$result= Korisnik::where('korsnicko_ime',$_POST['user_name_web'])->where('lozinka',$_POST['loginPassword'])->first();
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

?>























