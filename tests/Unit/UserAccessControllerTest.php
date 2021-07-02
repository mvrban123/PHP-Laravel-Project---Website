<?php

namespace Tests\Unit;

use App\Http\Controllers\DbControllers\OvlastController;
use App\Http\Controllers\UserAccessController;
use App\Models\Ovlast;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAccessControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testBasicTest()
    {
        
        $ulogaKorisnik = 1;
        $nazivFunkcionalnosti = 'dashboard';
        $result = UserAccessController::determineAccess($ulogaKorisnik, $nazivFunkcionalnosti);

        echo('rezultat = '. $result);

        $this->assertTrue( $result == 2, "Nema access");
        
    }


public function testOvlastControllerTest(){
       

        $ulogaKorisnik = 5;
        $result = UserAccessController::getNazivFunkcionalnostiByUloga($ulogaKorisnik);

        foreach ($result as $naziv) {
            echo $naziv;
            
        }
        

        $this->assertTrue( $result[0] == 'Prazna lista', "Postoji lista");
    }


    
    

    
}
