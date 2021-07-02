<?php 

namespace App\Modules\Helpers\TokenHelper;

require_once('vendor/autoload.php');
require_once('vendor/firebase/phpjwt/src/JWT.php');

use App\Models\PristupniKlijenti;
use \Firebase\JWT\JWT;
use DateTime;
use Exception;

class TokenHelper
{    
    public function VerifyToken($token)
    {
        $jwt = $this->DecodeToken($token);
        $verified = null;

        if($jwt)
        {
            $partner =  $jwt->partner;
            $result = PristupniKlijenti::where('naziv_unq',$partner)->first();

            if($result && $jwt->iss == 'obitelji3plus.hr' && ($jwt->exp > time()))
            {
                $verified =  true;
            }
            else
            {
                $verified = false;
            }
        }

        return $verified;
    }


    public function GetTokenApi($token)
    {
        $jwt = $this->DecodeToken($token);
        $apiVersion = null;

        if($jwt)
        {
            if(isset($jwt->api))
            {
                $apiVersion = $jwt->api;
            }
            else
            {
                $apiVersion = null;
            }
        }

        return $apiVersion;
    }


    /**
     * Returns true if token expirred.
     */
    public function CheckTokenIfExpired($token)
    {
        $jwt = $this->DecodeToken($token);
        $expired = null;

        if($jwt)
        {
            $jwtExp = $jwt->exp;
            $expired = time() > $jwtExp;
        }
        
        return $expired;
    }


    public function RenewTokenExpiryDate($token)
    {
        $jwt = $this->DecodeToken($token);
        if($jwt)
        {
            $issuedAt = time();
            $notBefore  = $issuedAt+1;
            $expire = $notBefore + 31104000;
            $jwt->exp = $expire;
            $jwt = $this->EncodeToken($jwt);
        }

        return $jwt;
    }
    

    public function GetUserEmail($token)
    {
        $jwt = $this->DecodeToken($token);
        $userEmail = null;

        if($jwt)
        {
            $userEmail = $jwt->sub;
        }
        
        return $userEmail;
    }


    public function RecordUser($userEmail, $token)
    {
        $jwt = null;
        
        if($this->VerifyToken($token))
        {
            $jwt = $this->DecodeToken($token);
            if($jwt)
            {
                $jwt->sub = $userEmail;
                $jwt = $this->EncodeToken($jwt);
            }
        }
    
        return $jwt;
    }
    

    public function CheckIfInactivityExpired($token)
    {
        $jwt = $this->DecodeToken($token);
        $inactiveExpired = null;
        
        if($jwt)
        {
            $inactiveExpired = time() > $jwt->ina;
        }

        return $inactiveExpired;        
    }


    public function RenewInactivity($token)
    {
        $jwt = $this->DecodeToken($token);

        if($jwt)
        {
            $config = (include 'config/config.php');
            $jwt->ina = time() + $config['allowedInactivityPeriod'] + 1;
            $jwt = $this->EncodeToken($jwt);
        }
        
        return $jwt;
    }


    public function ConstructTokenResponseData($token)
    {
        $decodedToken = $this->DecodeToken($token);
        $data = null;

        if($decodedToken)
        {
            $data = [
                "status" => "OK", 
                'access_token' => $token,
                'expires_in' => $decodedToken->exp,
                'issued' => date("d M Y H:i:s", $decodedToken->iat),
                'expires' => date("d M Y H:i:s", $decodedToken->exp)
            ];
    
            $data = json_encode(array("data" => $data));
        }

        return $data;
    }


    /**
     * Returns access token and additional parameters.
     */
    private function EncodeToken($token)
    {
        $config = (include 'config/config.php');
        $secretKey = $config['jwt']['key'];
        $algorithm = $config['jwt']['algorithm'];
        
        $token = json_encode($token);

        try
        {
            $jwt = JWT::encode($token, $secretKey, $algorithm);
        }
        
        catch(Exception $e)
        {
            return null;
        }
    
        return $jwt;
    }
    
    
    private function DecodeToken($token)
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
    
    
    public function GetTime()
    {
        return date('Y-m-d H:i:s');
    }
}