<?php

use Illuminate\Database\Seeder;
use App\Models\Ovlast;

class OvlastTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ovlasti_data_array = $this->createData();

        foreach($ovlasti_data_array as $ovlast)
        {
            $ovlast->save();
        }
    }

    private function createData()
    {
        $ovlast_1 = new Ovlast();
        $ovlast_2 = new Ovlast();
        $ovlast_3 = new Ovlast();

        $ovlast_1->uloge_id = 1;
        $ovlast_1->funkcionalnosti_id = 1;
        $ovlast_1->razine_ovlasti_id = 3;

        $ovlast_2->uloge_id = 2;
        $ovlast_2->funkcionalnosti_id = 1;
        $ovlast_2->razine_ovlasti_id = 1;

        $ovlast_3->uloge_id = 3;
        $ovlast_3->funkcionalnosti_id = 1;
        $ovlast_3->razine_ovlasti_id = 1;


        $ovlasti_data_array = array(
            $ovlast_1,
            $ovlast_2,
            $ovlast_3
        );

        return $ovlasti_data_array;
    }
}
