<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Uloga;

class UlogaModelDeleteTest extends TestCase

{

    public function testUloga()
    {
        $target_id = 999;

        $result = Uloga::where('id', $target_id)->delete();

        if ($result)
        {
            echo($result);
            echo("\nUloga deleted succesfully!");
        }

        $this->assertTrue($result == 1, "\nUloga not deleted in database.");
    }
}