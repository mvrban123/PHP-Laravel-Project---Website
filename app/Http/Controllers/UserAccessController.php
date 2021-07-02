<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DbControllers\FunkcionalnostController;
use App\Http\Controllers\DbControllers\OvlastController;
use App\Http\Controllers\DbControllers\RazinaOvlastiController;
use App\Models\Korisnik;
use App\Models\Ovlast;
use App\Modules\Helpers\TokenHelper\TokenHelper;
use Illuminate\Http\Request;

class UserAccessController extends Controller
{
    private $tokenHelperObj = null;
    private $tokenValue = null;
    private $userObj = null;
    

    public function DetermineAccessWithToken(
        $funkcionalnostId, $potrebnaRazinaOvlastiId, Request $request
    )
    {
        $this->tokenHelperObj = new TokenHelper();

        // 1. CheckIfTokenValid
        $resultValid = $this->CheckIfTokenValid($request);

        if($resultValid["status"] == "ok")
        {
            $apiVersion = $this->tokenHelperObj->GetTokenApi(
                $this->tokenValue
            );

            if($apiVersion < 3)
            {
                $resultValid = array(
                    "status" => "ok",
                    "response_code" => 200,
                    "message" => "Access granted."
                );
            }
            else
            {
                $resultValid = $this->DetermineUserAccessRight(
                    $funkcionalnostId, 
                    $potrebnaRazinaOvlastiId,
                    $this->tokenValue
                );
            }
        }

        return null;
    }


    private function DetermineUserAccessRight(
        $funkcionalnostId, $potrebnaRazinaOvlastiId, $token
    )
    {
        // 1. dohvati i provjeri korisnika
        $accessResult = $this->IdentifyUserFromToken(
            $this->tokenValue
        );

        if($accessResult["status"] == "ok")
        {
            // 2. provjeri pravo pristupa
            // $this->userObj = $identifiedUserResult["user_data"];

            $userRoleId = $this->userObj->uloge_uloga_id;
            
            $permission = Ovlast::where([
                ['uloge_id', '=', $userRoleId],
                ['funkcionalnosti_id', '=', $funkcionalnostId],
                ['razine_ovlasti_id', '=', $potrebnaRazinaOvlastiId]
            ])->first();

            if($permission)
            {
                $accessResult = array(
                    "status" => "ok",
                    "response_code" => 200,
                    "message" => "Access granted."
                );
            }
            else
            {
                $accessResult = array(
                    "status" => "error",
                    "response_code" => 400,
                    "message" => "Access not allowed."
                );
            }
        }
        
        return $accessResult;
    }


    private function IdentifyUserFromToken($token)
    {
        $userEmail = $this->tokenHelperObj->GetUserEmail($token);
        $userData = Korisnik::where('email', '=', $userEmail)->first();

        if($userData)
        {
            $this->userObj = $userData;
            $response_array = array(
                "status" => "ok",
                "response_code" => 205,
                "message" => "User successfully identified."
            );
        }
        else
        {
            $response_array = array(
                "status" => "error",
                "response_code" => 406,
                "message" => "Unauthorized request. User not found."
            );
        }

        return $response_array;
    }

    /** 
     * Izvršava niz naredbi za provjeru postojanja i ispravnosti tokena.
    */
    private function CheckIfTokenValid(Request $request)
    {
        $resultValid = $this->CheckForAuthToken($request);

        if($resultValid["status"] == "ok")
        {
            $authorizationArray = explode(
                " ", $request->header('Authorization')
            );

            // dohvati vrijednost tokena
            $tokenValue = $authorizationArray[1];
            $this->tokenValue = $tokenValue;
            $resultValid = $this->CheckTokenVerified($tokenValue);     
            
            if($resultValid["status"] == "ok")
            {
                $resultValid = $this->CheckTokenActive($tokenValue);

                if($resultValid["status"] == "ok")
                {
                    $resultValid = $this->CheckTokenNotExpired($tokenValue);
                }
            }
        }

        return $resultValid;
    }


    /**
     * Provjerava sadrži li zaglavlje zahtjeva Bearer token validnog formata.
     */
    private function CheckForAuthToken(Request $request)
    {
        if(!$request->hasHeader('Authorization')){

            $response_array = array(
                "status" => "error",
                "response_code" => 401,
                "message" => "Unauthorized request. Bearer token missing in header."
            );
        }

        $authorizationArray = explode(" ", $request->header('Authorization'));
        if(count($authorizationArray) !=2 || $authorizationArray[0] != "Bearer"){

            $response_array = array(
                "status" => "error",
                "response_code" => 402,
                "message" => "Unauthorized request. Bearer token incorrect format."
            );
        }

        $response_array = array(
            "status" => "ok",
            "response_code" => 201,
            "message" => "Token exists."
        );

        return $response_array;
    }

    /**
     * Provjerava odnosi li se token na validnog klijenta.
     */
    private function CheckTokenVerified($token)
    {
        $tokenVarified = $this->tokenHelperObj->VerifyToken($token);

        if($tokenVarified)
        {
            $response_array = array(
                "status" => "ok",
                "response_code" => 202,
                "message" => "Token verirfied."
            );
        }
        else
        {
            $response_array = array(
                "status" => "ok",
                "response_code" => 403,
                "message" => "Unauthorized request. Token not verirfied. Ensure your client is registered at Obitelji3Plus."
            );
        }

        return $response_array;
    }

    /**
     * Dohvaća podatak je li istekao period dozvoljene neaktivnosti.
     */
    private function CheckTokenActive($token)
    {
        $tokenInactive = $this->tokenHelperObj->CheckIfInactivityExpired(
            $token
        );

        if(!$tokenInactive)
        {
            $response_array = array(
                "status" => "ok",
                "response_code" => 203,
                "message" => "Token active."
            );
        }
        else
        {
            $response_array = array(
                "status" => "error",
                "response_code" => 404,
                "message" => "Unauthorized request. Your allowed inactivity period expired. Please, log in back again."
            );
        }

        return $response_array;
    }

    /**
     * Provjerava je li token istekao.
     */
    private function CheckTokenNotExpired($token)
    {
        $tokenExpired = $this->tokenHelperObj->CheckTokenIfExpired($token);

        if(!$tokenExpired)
        {
            $response_array = array(
                "status" => "ok",
                "response_code" => 204,
                "message" => "Token not expired."
            );
        }
        else
        {
            $response_array = array(
                "status" => "error",
                "response_code" => 405,
                "message" => "Unauthorized request. Token expired. Please, authenticate your client again, and log in to get a new token."
            );
        }

        return $response_array;
    }


    /*
     Provjerava ima li uloga dozvolu pristupu funkcionalnosti, ako ima vraća koju razinu ovlasti ima.
     $ulogaKorisnik je id uloge korisnika koji pokušava pristupiti određenoj stranici
     $nazivFunkcionalnost je nazi stranice kojoj korisnik pokušava pristupiti
    */
    public static function determineAccess(int $ulogaKorisnik, string $nazivFunkcionalnost ){
        
        
        $funkcionalnosti = FunkcionalnostController::getByNaziv($nazivFunkcionalnost);

        

        $korisnikovaOvlast = OvlastController::getRazineOvlastiByUlogeIdAndFunkcionalnost($ulogaKorisnik, $funkcionalnosti->id);
       

        $razinaOvlastiKodnaVrijednost = RazinaOvlastiController::getKodnaVrijednostById($korisnikovaOvlast);
        

        return $razinaOvlastiKodnaVrijednost;
        
    }


    /*
     Funkcija vraća listu naziva funkcionalnosti (koji su istovremeno i nazivi stranica) kojima neka uloga može pristupiti.
     Ako ne pronađe niti jednu ulogu vraća listu sa 1 elementom koji ima zapisano 'Prazna lista'
     Prima parametar koji je id uloge.
    */
    public static function getNazivFunkcionalnostiByUloga(int $ulogaKorisnik){
        $sveKorisnikoveOvlasti = OvlastController::getByUloge($ulogaKorisnik);
        
        if(count($sveKorisnikoveOvlasti) != 0){
            foreach ($sveKorisnikoveOvlasti as $ovlast) {
                $idFunkcionalnosti = $ovlast->funkcionalnosti_id;
                if($idFunkcionalnosti != 0){
                    $listNazivaFunkcionalnosti[] = FunkcionalnostController::getNazivById($idFunkcionalnosti);
                   
                }
                
            }
            
            return $listNazivaFunkcionalnosti;
        }
        /*
         Zato što se očekuje lista kao odgovor
        */
        else{
            $listNazivaFunkcionalnosti[0] = 'Prazna lista';
            return $listNazivaFunkcionalnosti;
        }
        
    }    
}