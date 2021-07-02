<?php

use Illuminate\Database\Seeder;
use App\Models\KategorijaPredloska;

class KategorijePredlozakaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategorije_array = $this->createData();

        foreach($kategorije_array as $kategorija) {
            $kategorija->save();
        }
    }

    private function createData()
    {
        $katId_1 = new KategorijaPredloska();
        $katId_2 = new KategorijaPredloska();
        $katId_3 = new KategorijaPredloska();
        
        $katId_1->id = 1;
        $katId_1->naziv = 'Obavijesti o registraciji';

        $katId_2->id = 2;
        $katId_2->naziv = 'Obavijesti o članarini';

        $katId_3->id = 3;
        $katId_3->naziv = 'Pozdravi novim članovima';

        $kategorije_array = array(
            $katId_1,
            $katId_2,
            $katId_3
        );

        return $kategorije_array;
    }
}
