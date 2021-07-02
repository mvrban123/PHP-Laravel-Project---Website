<?php

use Illuminate\Database\Seeder;
use App\Models\Adresa;


class AdresaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $addresses_data_array = $this->createData();

        foreach($addresses_data_array as $address)
        {
            $address->save();
        }
    }

    private function createData()
    {
        $adresa_1 = new Adresa();
        $adresa_2 = new Adresa();
        $adresa_3 = new Adresa();


        $adresa_1->ulica_broj = "test_Ulica Bojana Bojamke 2";
        $adresa_1->grad_naselje = "test_Peti Svetar";
        $adresa_1->drzava = "test_Nigdjezemska";
        $adresa_1->postanski_broj = "test_01234";
        $adresa_1->rucni_unos = "1";

        $adresa_2->ulica_broj = "test_Trg Pavla Pauqa 2";
        $adresa_2->ulica_broj_dodatak = "test_A";
        $adresa_2->rucni_unos = "0";
        $adresa_2->mjesta_id = 1;       

        $adresa_3->ulica_broj = "test_Trg Dobrog vina";
        $adresa_3->grad_naselje = "test_Vinograd";
        $adresa_3->drzava = "test_Hrvatska";
        $adresa_3->postanski_broj = "test_01234";
        $adresa_3->rucni_unos = "1";
        
        $addresses_array = array(
            $adresa_1,
            $adresa_2,
            $adresa_3
        );

        return $addresses_array;
    }
}
