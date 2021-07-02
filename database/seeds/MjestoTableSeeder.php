<?php

use Illuminate\Database\Seeder;
use App\Models\Mjesto;


class MjestoTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $csv_data = $this->createData();

    # OVO JE POTREBNO SAMO ZA TESTIRANJE UNOSA
    # TODO: makni!
    //$csv_data = array($csv_data[0]);
    
    foreach($csv_data as $idx => $place)
    {
      $mjesto = new Mjesto();

      if($idx == 0)
      {
        // da znamo da u bazi sigurno posotji mjesto s tim ID-jem
        $mjesto->id = 1;
      }

      $mjesto->naziv = $place["Naselje"];
      $mjesto->postanski_broj = $place["BrojPu"];
      $mjesto->drzave_id = 1;
      $mjesto->save();
    }
  }

  public function createData()
  {
    $file = dirname(__FILE__) . '/../../database_files/hr_naselja_gradovi/hr_naselja_air_2020.csv';

    $csv = array_map('str_getcsv', file($file));
    array_walk($csv, function(&$a) use ($csv) {
      $a = array_combine($csv[0], $a);
    });
    array_shift($csv); # remove column header

    return $csv;
  }
}


/*
    $csv = array_map('str_getcsv', file($file));
    array_walk($csv, function(&$a) use ($csv) {
      $a = array_combine($csv[0], $a);
    });
    array_shift($csv); # remove column header

    src: https://www.php.net/manual/en/function.str-getcsv.php

*/