<?php

use Illuminate\Database\Seeder;
use App\Models\Uloga;

class UlogaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uloga_objects_array = $this->createData();

        foreach($uloga_objects_array as $uloga) {
            $uloga->save();
        }
    }

    private function createData()
    {
        $uloga_1 = new Uloga();
        $uloga_2 = new Uloga();
        $uloga_3 = new Uloga();
        
        $uloga_1->id = 1;
        $uloga_1->uloga_opis = 'administrator';
        
        $uloga_2->id = 2;
        $uloga_2->uloga_opis = 'roditelj';

        $uloga_3->id = 3;
        $uloga_3->uloga_opis = 'dijete';    

        $uloga_objects_array = array(
            $uloga_1,
            $uloga_2,
            $uloga_3
        );

        return $uloga_objects_array;
    }
}