<?php
namespace Tests\Unit;

use App\Http\Controllers\DbControllers\UlogaController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Uloga;

class UlogaTest extends TestCase

{
    /*
     Provjerava postoji li novo unseseni redak u tablici
     ako postoji $result = true i test prolazi
    */
    public function testInsert()
    {
        
        $entitet['uloga_opis'] = 'Test Insert';
        
        $insert = UlogaController::insert($entitet);

        $provjera = Uloga::all();
        $result = false;
        foreach ($provjera as $redak ) {
            if($redak->id == $insert->id){
                $result = true;
            }
        }
        
        $this->assertTrue( $result == true, "New uloga not saved to database.");
    }

    /*
     Provjerava je su li pročitani podaci iz tablice
     ako jesu, $result = true i test prolazi
    */
    public function testReadAll(){
        $result = UlogaController::readAll();
        foreach ($result  as $redak) {
            echo($redak. '\n');
        }

        $this->assertTrue(isset($result), "Can't read uloga.");

    }

    /*
     Provjerava je li na zadanom retku izvršen update atributa 'uloga_opis'
     ako postoji $result = true i test prolazi
    */
    public function testUpdate(){
        $entitet['uloga_opis'] = 'Test Update';
        $entitet['id'] = '9';

        UlogaController::update($entitet);
        $result = false;
        $provjera = Uloga::find(9);
        if($provjera->uloga_opis == 'Test Update'){
            $result = true;
        }

        $this->assertTrue($result == true, "Can't update uloga.");
        
    }

    /*
     Provjerava postoji li redak u tablici sa atributom 'id' koji je obrisan pozivom funkcije
     ako ne postoji $result = true i test prolazi
    */
    public function testDelete(){
        
        $id = 21;
        UlogaController::delete($id);

        $provjera = Uloga::all();
        $result = true;
        foreach ($provjera as $redak ) {
            if($redak->id == $id){
                $result = false;
            }
        }
        
        
        $this->assertTrue($result == true, "Uloga not deleted.");
    }
}