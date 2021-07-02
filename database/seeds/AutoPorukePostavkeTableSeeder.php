<?php

use Illuminate\Database\Seeder;
use App\Models\AutoPorukaPostavke;

class AutoPorukePostavkeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $auto_postavke_data_array = $this->createData();

        foreach($auto_postavke_data_array as $postavka)
        {
            $postavka->save();
        }
    }

    private function createData()
    {
        $ap_pos1 = new AutoPorukaPostavke();
        $ap_pos2 = new AutoPorukaPostavke();
        $ap_pos3 = new AutoPorukaPostavke();

        $ap_pos1->id = 1;
        $ap_pos1->omoguceno = 1;
        $ap_pos1->naziv = 'uspjesna_registracija_obitelji';
        $ap_pos1->opis = 'Automatska obavijest o uspješnoj registraciji';
        $ap_pos1->email_predlosci_id = 1;
        $ap_pos1->tipovi_odgode_id = 1; // 5 min

        $ap_pos2->id = 2;
        $ap_pos2->omoguceno = 1;
        $ap_pos2->naziv = 'neplacena_clanarina';
        $ap_pos2->opis = 'Obavijest o neplaćenoj članarini';
        $ap_pos2->email_predlosci_id = 2; 
        $ap_pos2->tipovi_odgode_id = 7; // 5 min

        $ap_pos3->id = 3;
        $ap_pos3->omoguceno = 1;
        $ap_pos3->naziv = 'promjena_lozinke';
        $ap_pos3->opis = 'Obavijest o odobrenom zahtjevu za promjenu lozinke';
        $ap_pos3->tipovi_odgode_id = 1; // 5 min


        $auto_postavke_data_array = array(
            $ap_pos1,
            $ap_pos2,
            $ap_pos3
        );

        return $auto_postavke_data_array;
    }
}