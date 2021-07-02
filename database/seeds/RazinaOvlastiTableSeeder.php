<?php

use Illuminate\Database\Seeder;
use App\Models\RazinaOvlasti;

class RazinaOvlastiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $razine_data_array = $this->createData();

        foreach($razine_data_array as $razina)
        {
            $razina->save();
        }
    }

    private function createData()
    {
        $razina_1 = new RazinaOvlasti();
        $razina_2 = new RazinaOvlasti();
        $razina_3 = new RazinaOvlasti();

        $razina_1->id = 1;
        $razina_1->kodna_vrijednost = 0;
        $razina_1->opis = "not authorized";

        $razina_2->id = 2;
        $razina_2->kodna_vrijednost = 1;
        $razina_2->opis = "read";

        $razina_3->id = 3;
        $razina_3->kodna_vrijednost = 2;
        $razina_3->opis = "write";

        $razine_data_array = array(
            $razina_1,
            $razina_2,
            $razina_3
        );

        return $razine_data_array;
    }
}
