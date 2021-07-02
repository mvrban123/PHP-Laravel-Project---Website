<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Uloga;

class UlogaModelUpdateTest extends TestCase

{

    public function testUloga()
    {
        $update_value = "Testna uloga";
        $target_id = 999;

        $result = Uloga::where('id', $target_id)
            ->update(['uloga_opis' => $update_value]);



        if ($result)
        {
            echo($result);
            echo("\nUloga updated succesfully!");
        }

        $this->assertTrue($result == 1, "\nUloga not updated in database.");
    }
}