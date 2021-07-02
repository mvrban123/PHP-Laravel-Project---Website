<?php

use Illuminate\Database\Seeder;
use App\Models\Korisnik;
use Illuminate\Support\Facades\Hash;

class KorisnikTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $korisnik_data_array = $this->createData();

        foreach($korisnik_data_array as $korisnik)
        {
            $korisnik->save();
        }
    }

    private function createData() 
    {
        $rod1_ob1 = new Korisnik();
        $rod2_ob1 = new Korisnik();
        
        $rod1_ob2 = new Korisnik();

        $dij1_ob1 = new Korisnik();
        $dij2_ob1 = new Korisnik();
        $dij3_ob1 = new Korisnik();

        $dij1_ob2 = new Korisnik();
        $dij2_ob2 = new Korisnik();
        $dij3_ob2 = new Korisnik();

        $administrator = new Korisnik();

        // ob1

        $rod1_ob1->id = 1;
        $rod1_ob1->obiteljski_identifikatori_id = 1;
        $rod1_ob1->ime = "Spomenka";
        $rod1_ob1->prezime = "Frankopan";
        $rod1_ob1->oib = "12345678901";
        $rod1_ob1->datum_rodenja = date('Y-m-d', strtotime('1960-06-23T20:47:48-04:00'));
        $rod1_ob1->spol_flag = "F";
        $rod1_ob1->mobilni_telefon = "+385 96 222 333";
        $rod1_ob1->fiksni_telefon = "+385 43 591 666";
        $rod1_ob1->zanimanje = "Zubarka";
        $rod1_ob1->bracni_status_flag = "1";
        $rod1_ob1->prima_obavijesti_flag = "0";
        $rod1_ob1->zeli_aktivno_sudjelovati_flag = "1";
        $rod1_ob1->potvrdeno_clanstvo_flag = "1";
        $rod1_ob1->korisnicko_ime = "test_my_zubarka";
        // $rod1_ob1->lozinka_sol = "rNDmsSgVSlrwhHQTrNDmsSgVSlrwhHQTrNDmsSgVSlrwh";
        // $rod1_ob1->lozinka_SHA256 = "moja_lozinka";
        $rod1_ob1->lozinka_a2 = Hash::make(
            "moja_lozinka"
        );
        $rod1_ob1->lozinka_s1 = sha1("moja_lozinka");
        $rod1_ob1->email = "cigvuahe@jejzis.af";
        $rod1_ob1->datum_vrijeme_registracije = date('Y-m-d H:i:s');
        $rod1_ob1->radni_interesi = "Dentalna medicina, Razvoja psihologija";
        $rod1_ob1->adrese_adresa_id = 1;
        $rod1_ob1->razine_obrazovanja_razina_obrazovanja_id = 6;
        $rod1_ob1->uloge_uloga_id = 2;

        $rod2_ob1->id = 2;
        $rod2_ob1->obiteljski_identifikatori_id = $rod1_ob1->obiteljski_identifikatori_id;
        $rod2_ob1->ime = "Fran";
        $rod2_ob1->prezime = "Frankopan";
        $rod2_ob1->oib = "22345678901";
        $rod2_ob1->datum_rodenja = date('Y-m-d', strtotime('1950-06-23T20:47:48-04:00'));
        $rod2_ob1->spol_flag = "M";
        $rod2_ob1->mobilni_telefon = "+385 96 222 333";
        $rod2_ob1->fiksni_telefon = "+385 43 591 666";
        $rod2_ob1->zanimanje = "Bibliotekar";
        $rod2_ob1->bracni_status_flag = "1";
        $rod2_ob1->prima_obavijesti_flag = "0";
        $rod2_ob1->zeli_aktivno_sudjelovati_flag = "1";
        $rod2_ob1->potvrdeno_clanstvo_flag = "1";
        $rod2_ob1->korisnicko_ime = "test_wiki_bib";
        // $rod2_ob1->lozinka_sol = "rNDmsSgVSlrwhHQTrNDmsSgVSlrwhHQTrNDmsSgVSlrwh";
        // $rod2_ob1->lozinka_SHA256 = "moja_lozinka";
        $rod2_ob1->lozinka_a2 = Hash::make(
            "moja_lozinka"
        );
        $rod2_ob1->lozinka_s1 = sha1("moja_lozinka");
        $rod2_ob1->email = "wuh@pap.er";
        $rod2_ob1->datum_vrijeme_registracije = date('Y-m-d H:i:s');
        $rod2_ob1->radni_interesi = "Excel, WOrd, Računari";
        $rod2_ob1->adrese_adresa_id = 1;
        $rod2_ob1->razine_obrazovanja_razina_obrazovanja_id = 4;
        $rod2_ob1->uloge_uloga_id = 2;

        $dij1_ob1->id = 3;
        $dij1_ob1->obiteljski_identifikatori_id = $rod1_ob1->obiteljski_identifikatori_id;
        $dij1_ob1->ime = "Saša Baron";
        $dij1_ob1->prezime = "Frankopan";
        $dij1_ob1->oib = "22545678901";
        $dij1_ob1->datum_rodenja = date('Y-m-d', strtotime('2000-05-23T20:47:48-04:00'));
        $dij1_ob1->spol_flag = "M";
        $dij1_ob1->korisnicko_ime = "test_borat_nice";
        // $dij1_ob1->lozinka_sol = "rNDmsSgVSlrwhHQTrNDmsSgVSlrwhHQTrNDmsSgVSlrwh";
        // $dij1_ob1->lozinka_SHA256 = "moja_lozinka";
        $dij1_ob1->lozinka_a2 = Hash::make(
            "moja_lozinka"
        );
        $dij1_ob1->lozinka_s1 = sha1("moja_lozinka");
        $dij1_ob1->datum_vrijeme_registracije = date('Y-m-d H:i:s');
        $dij1_ob1->adrese_adresa_id = 1;
        $dij1_ob1->uloge_uloga_id = 3;
        $dij1_ob1->korisnici_roditelj_1 = 1;
        $dij1_ob1->korisnici_roditelj_2 = 2;

        $dij2_ob1->id = 4;
        $dij2_ob1->obiteljski_identifikatori_id = $rod1_ob1->obiteljski_identifikatori_id;
        $dij2_ob1->ime = "Elma";
        $dij2_ob1->prezime = "Frankopan";
        $dij2_ob1->oib = "22545678701";
        $dij2_ob1->datum_rodenja = date('Y-m-d', strtotime('2005-05-23T20:47:48-04:00'));
        $dij2_ob1->spol_flag = "F";
        $dij2_ob1->korisnicko_ime = "test_mala_cici";
        // $dij2_ob1->lozinka_sol = "rNDmsSgVSlrwhHQTrNDmsSgVSlrwhHQTrNDmsSgVSlrwh";
        // $dij2_ob1->lozinka_SHA256 = "moja_lozinka";
        $dij2_ob1->lozinka_a2 = Hash::make(
            "moja_lozinka"
        );
        $dij2_ob1->lozinka_s1 = sha1("moja_lozinka");
        $dij2_ob1->datum_vrijeme_registracije = date('Y-m-d H:i:s');
        $dij2_ob1->adrese_adresa_id = 1;
        $dij2_ob1->uloge_uloga_id = 3;
        $dij2_ob1->korisnici_roditelj_1 = 1;
        $dij2_ob1->korisnici_roditelj_2 = 2;

        $dij3_ob1->id = 5;
        $dij3_ob1->obiteljski_identifikatori_id = $rod1_ob1->obiteljski_identifikatori_id;
        $dij3_ob1->ime = "Emma";
        $dij3_ob1->prezime = "Frankopan";
        $dij3_ob1->oib = "22545677901";
        $dij3_ob1->datum_rodenja = date('Y-m-d', strtotime('2004-04-21T20:47:48-04:00'));
        $dij3_ob1->spol_flag = "F";
        $dij3_ob1->korisnicko_ime = "test_hermona123";
        // $dij3_ob1->lozinka_sol = "rNDmsSgVSlrwhHQTrNDmsSgVSlrwhHQTrNDmsSgVSlrwh";
        // $dij3_ob1->lozinka_SHA256 = "moja_lozinka";
        $dij3_ob1->lozinka_a2 = Hash::make(
            "moja_lozinka"
        );
        $dij3_ob1->lozinka_s1 = sha1("moja_lozinka");
        $dij3_ob1->datum_vrijeme_registracije = date('Y-m-d H:i:s');
        $dij3_ob1->adrese_adresa_id = 1;
        $dij3_ob1->uloge_uloga_id = 3;
        $dij3_ob1->korisnici_roditelj_1 = 1;
        $dij3_ob1->korisnici_roditelj_2 = 2;


        // ob2


        $rod1_ob2->id = 6;
        $rod1_ob2->obiteljski_identifikatori_id = 2;
        $rod1_ob2->ime = "Željko";
        $rod1_ob2->prezime = "Zaplatić";
        $rod1_ob2->oib = "12666078901";
        $rod1_ob2->datum_rodenja = date('Y-m-d', strtotime('1989-11-23T20:47:48-04:00'));
        $rod1_ob2->spol_flag = "M";
        $rod1_ob2->mobilni_telefon = "+385 92 3222 3633";
        $rod1_ob2->zanimanje = "Softverski inženjer";
        $rod1_ob2->bracni_status_flag = "0";
        $rod1_ob2->prima_obavijesti_flag = "1";
        $rod1_ob2->zeli_aktivno_sudjelovati_flag = "1";
        $rod1_ob2->potvrdeno_clanstvo_flag = "1";
        $rod1_ob2->korisnicko_ime = "test_softeras12";
        // $rod1_ob2->lozinka_sol = "rNDmsSgVSlrwhHQTrNDmsSgVSlrwhHQTrNDmsSgVSlrwh";
        // $rod1_ob2->lozinka_SHA256 = "moja_lozinka";
        $rod1_ob2->lozinka_a2 = Hash::make(
            "moja_lozinka"
        );
        $rod1_ob2->lozinka_s1 = sha1("moja_lozinka");
        $rod1_ob2->email = "het@etnamfib.ag";
        $rod1_ob2->datum_vrijeme_registracije = date('Y-m-d H:i:s');
        $rod1_ob2->radni_interesi = "Razvoj mobilnih aplikacija, Razvoj Web-a, Rukovođenje projektima";
        $rod1_ob2->adrese_adresa_id = 2;
        $rod1_ob2->razine_obrazovanja_razina_obrazovanja_id = 4;
        $rod1_ob2->uloge_uloga_id = 2;

        $dij1_ob2->id = 7;
        $dij1_ob2->obiteljski_identifikatori_id = $rod1_ob2->obiteljski_identifikatori_id;
        $dij1_ob2->ime = "Srđan";
        $dij1_ob2->prezime = "Zaplatić";
        $dij1_ob2->oib = "12666078907";
        $dij1_ob2->datum_rodenja = date('Y-m-d', strtotime('2000-01-01T20:47:48-04:00'));
        $dij1_ob2->spol_flag = "M";
        $dij1_ob2->korisnicko_ime = "test_srdjan_mali";
        // $dij1_ob2->lozinka_sol = "rNDmsSgVSlrwhHQTrNDmsSgVSlrwhHQTrNDmsSgVSlrwh";
        // $dij1_ob2->lozinka_SHA256 = "moja_lozinka";
        $dij1_ob2->lozinka_a2 = Hash::make(
            "moja_lozinka"
        );
        $dij1_ob2->lozinka_s1 = sha1("moja_lozinka");
        $dij1_ob2->datum_vrijeme_registracije = date('Y-m-d H:i:s');
        $dij1_ob2->adrese_adresa_id = 2;
        $dij1_ob2->uloge_uloga_id = 3;
        $dij1_ob2->korisnici_roditelj_1 = 6;

        $dij2_ob2->id = 8;
        $dij2_ob2->obiteljski_identifikatori_id = $rod1_ob2->obiteljski_identifikatori_id;
        $dij2_ob2->ime = "Ugljenka";
        $dij2_ob2->prezime = "Zaplatić";
        $dij2_ob2->oib = "22545678708";
        $dij2_ob2->datum_rodenja = date('Y-m-d', strtotime('2001-05-23T20:47:48-04:00'));
        $dij2_ob2->spol_flag = "F";
        $dij2_ob2->korisnicko_ime = "test_milo_dijete";
        // $dij2_ob2->lozinka_sol = "rNDmsSgVSlrwhHQTrNDmsSgVSlrwhHQTrNDmsSgVSlrwh";
        // $dij2_ob2->lozinka_SHA256 = "moja_lozinka";
        $dij3_ob2->lozinka_a2 = Hash::make(
            "moja_lozinka"
        );
        $dij3_ob2->lozinka_s1 = sha1("moja_lozinka");
        $dij2_ob2->datum_vrijeme_registracije = date('Y-m-d H:i:s');
        $dij2_ob2->adrese_adresa_id = 2;
        $dij2_ob2->uloge_uloga_id = 3;
        $dij2_ob2->korisnici_roditelj_1 = 6;

        $dij3_ob2->id = 9;
        $dij3_ob2->obiteljski_identifikatori_id = $rod1_ob2->obiteljski_identifikatori_id;
        $dij3_ob2->ime = "Ana-Lena";
        $dij3_ob2->prezime = "Zaplatić";
        $dij3_ob2->oib = "22545677909";
        $dij3_ob2->datum_rodenja = date('Y-m-d', strtotime('2004-12-01T20:47:48-04:00'));
        $dij3_ob2->spol_flag = "F";
        $dij3_ob2->korisnicko_ime = "test_lenolena";
        // $dij3_ob2->lozinka_sol = "rNDmsSgVSlrwhHQTrNDmsSgVSlrwhHQTrNDmsSgVSlrwh";
        // $dij3_ob2->lozinka_SHA256 = "moja_lozinka";
        $dij3_ob2->lozinka_a2 = Hash::make(
            "moja_lozinka"
        );
        $dij3_ob2->lozinka_s1 = sha1("moja_lozinka");
        $dij3_ob2->datum_vrijeme_registracije = date('Y-m-d H:i:s');
        $dij3_ob2->adrese_adresa_id = 2;
        $dij3_ob2->uloge_uloga_id = 3;
        $dij3_ob2->korisnici_roditelj_1 = 6;


        // administrator


        $administrator->id = 10;
        $administrator->ime = "Miljenko";
        $administrator->prezime = "Draganić";
        $administrator->oib = "12666078988";
        $administrator->datum_rodenja = date('Y-m-d', strtotime('1992-01-01T20:47:48-04:00'));
        $administrator->spol_flag = "M";
        $administrator->korisnicko_ime = "test_moj_admin";
        // $administrator->lozinka_sol = "rNDmsSgVSlrwhHQTrNDmsSgVSlrwhHQTrNDmsSgVSlrwh";
        // $administrator->lozinka_SHA256 = "moja_lozinka";
        $administrator->lozinka_a2 = Hash::make(
            "ovu_lozinku_neznam"
        );
        $administrator->lozinka_s1 = sha1("ovu_lozinku_neznam");
        $administrator->email = "moj.admin@mail.com";
        $administrator->datum_vrijeme_registracije = date('Y-m-d H:i:s');
        $administrator->adrese_adresa_id = 3;
        $administrator->uloge_uloga_id = 1;

        $korisnik_data_array = array(
            $rod1_ob1,
            $rod2_ob1,
            $rod1_ob2,
            $dij1_ob1,
            $dij2_ob1,
            $dij3_ob1,
            $dij1_ob2,
            $dij2_ob2,
            $dij3_ob2,
            $administrator
        );

        return $korisnik_data_array;
    }
}
