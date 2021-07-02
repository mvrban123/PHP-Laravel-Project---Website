<?php

use Illuminate\Database\Seeder;
use App\Models\Drzava;

class DrzavaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $domovina = new Drzava();
        $domovina->id = 1;
        $domovina->naziv = "Republika Hrvatska";
        $domovina->save();
    }
}
