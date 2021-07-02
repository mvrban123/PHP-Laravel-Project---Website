<?php

use Illuminate\Database\Seeder;
use App\Models\Funkcionalnost;

class FunkcionalnostiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $funkcionalnost_data_array = $this->createData();

        foreach($funkcionalnost_data_array as $funkcionalnost)
        {
            $funkcionalnost->save();
        }
    }

    private function createData()
    {
        $funk_1 = new Funkcionalnost();

        $funk_1->id = 1;
        $funk_1->naziv = "dashboard";

        $funkcionalnost_data_array = array(
            $funk_1
        );

        return $funkcionalnost_data_array;
    }
}
