<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Uloga;

class UlogaModelInsertTest extends TestCase

{

    public function testUloga()
    {
        $testUloga = new Uloga;
        $testUloga->id = 999;
        $testUloga->uloga_opis = "Član obitelji test";

        // ne postavljati kako bi se ipsravno testirale Eloquent funkcionalnosti
        // automatskog zapisivanja created_at, updated_at, te deleted_at atributa (SoftDelets) 
        // $testUloga->created_at = date('Y-m-d H:i:s');
        // $testUloga->updated_at = date('Y-m-d H:i:s');
        // $testUloga->deleted_at = null;


        $result = $testUloga->save();

        if ($result)
        {
            echo($result);
            echo("\nUloga saved succesfully!");
        }

        $this->assertTrue($result == 1, "\nNew uloga not saved to database.");
    }
}