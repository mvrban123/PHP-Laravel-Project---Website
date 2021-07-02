<?php

use Illuminate\Database\Seeder;
use App\Models\RazinaObrazovanja;

class RazinaObrazovanjaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $razine_data = $this->createData();

        foreach($razine_data as $razina)
        {
            $razina->save();
        }
    }

    private function createData()
    {
        $razine_vrijednosti = array(
            "Osnovna škola",
            "Srednja škola",
            "Viša stručna sprema / Bakalaureat (BA)",
            "Visoka stručna sprema / Magistar struke (MA)",
            "Poslijediplomski specijalistički studij",
            "Magisterij znanosti (mr. sc.)",
            "Doktorat znanosti (dr. sc.)"
        );
        
        $razine_data_array = array();

        for ($i = 0; $i < 7; $i++)
        {
            $razina = new RazinaObrazovanja();
            $razina->razina_obrazovanja_opis = $razine_vrijednosti[$i];
            $razine_data_array[] = $razina;
        }

        return $razine_data_array;
    }
}

/*
"osnovna škola",
"srednja škola",
"viša stručna sprema / bakalaureat (BA)",
"visoka stručna sprema / magistar struke (MA)",
"poslijediplomski specijalistički studij",
"magisterij znanosti (mr. sc.)",
"doktorat znanosti (dr. sc.)"

*/
