<?php

use App\Models\PristupniKlijent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UlogaTableSeeder::class);
        $this->call(DrzavaTableSeeder::class);
        $this->call(MjestoTableSeeder::class);
        $this->call(AdresaTableSeeder::class);
        $this->call(FunkcionalnostiTableSeeder::class);
        $this->call(RazinaOvlastiTableSeeder::class);
        $this->call(OvlastTableSeeder::class);
        $this->call(RazinaObrazovanjaTableSeeder::class);
        $this->call(ObiteljskiIdentifikatoriTableSeeder::class);
        $this->call(KorisnikTableSeeder::class);
        $this->call(KategorijePredlozakaTableSeeder::class);
        $this->call(TipoviOdgodeTableSeeder::class);
        $this->call(EmailPredlosciTableSeeder::class);
        $this->call(AutoPorukePostavkeTableSeeder::class);
        $this->call(EmailPorukeTableSeeder::class);
        $this->call(PristupniKlijentiTableSeeder::class);
    }
}