<?php

use Illuminate\Database\Seeder;
use App\Models\ObiteljskiIdentifikator;

class ObiteljskiIdentifikatoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ob_identifikatori_array = $this->createData();

        foreach($ob_identifikatori_array as $ob_id) {
            $ob_id->save();
        }
    }

    private function createData()
    {
        $obId_1 = new ObiteljskiIdentifikator();
        $obId_2 = new ObiteljskiIdentifikator();
        
        $obId_1->id = 1;
        $obId_2->id = 2;

        $ob_identifikatori_array = array(
            $obId_1,
            $obId_2
        );

        return $ob_identifikatori_array;
    }
}
