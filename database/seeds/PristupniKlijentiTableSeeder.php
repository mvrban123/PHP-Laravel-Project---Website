<?php

use Illuminate\Database\Seeder;
use App\Models\PristupniKlijenti;
use Illuminate\Support\Facades\Hash;

class PristupniKlijentiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pristupni_klijenti_data_array = $this->createData();

        foreach($pristupni_klijenti_data_array as $klijent)
        {
            $klijent->save();
        }
    }

    private function createData() 
    {
        $pk1 = new PristupniKlijenti();
        $pk2 = new PristupniKlijenti();
        $pk3 = new PristupniKlijenti();

        $pk1->id = 1;
        $pk2->id = 2;
        $pk3->id = 3;
        
        $pk1->naziv_unq = "webapp";
        $pk2->naziv_unq = "mobile";
        $pk3->naziv_unq = "partner_service";

        $pk1->lozinka = "Y'bItfwHQ5hgcS((jn7>5W|?3";
        $pk1->lozinka_hash = Hash::make(
            "Y'bItfwHQ5hgcS((jn7>5W|?3"
        );

        $pk2->lozinka = "d|g5*O=5yC*VU7q?~gxyMPZ6;";
        $pk2->lozinka_hash = Hash::make(
            "d|g5*O=5yC*VU7q?~gxyMPZ6;"
        );

        $pk3->lozinka = "b@gr,R6#i=vipHU0]nq\h.Rbs";
        $pk3->lozinka_hash = Hash::make(
            "b@gr,R6#i=vipHU0]nq\h.Rbs"
        );

		$expire = time() + 1 + 31104000;

        $pk1->istice = $expire;
        $pk2->istice = $expire;
        $pk3->istice = $expire;

        $pk1->omoguceno = "1";
        $pk2->omoguceno = "1";
        $pk3->omoguceno = "1";

        $pristupni_klijenti_data_array = array(
            $pk1,
            $pk2,
            $pk3
        );

        return $pristupni_klijenti_data_array;
    }
}
