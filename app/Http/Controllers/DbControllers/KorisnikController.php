<?php

namespace App\Http\Controllers\DbControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Korisnik;
use App\Http\Controllers\PrikazObiteljiController;

class KorisnikController extends Controller
{

    /*
     Funkcija kreaira novi redak u tablici
     $entitet je $_POST varijabla iz koje dohvaćaju vrijednosti atributa te se spremaju u novu ulogu
    */
    public static function insert($entitet){
        $korisnik = new Korisnik();

        $korisnik->ime = $entitet['ime'];
        $korisnik->prezime = $entitet['prezime'];
        $korisnik->oib = $entitet['oib'];
        $korisnik->datum_rodenja = $entitet['datum_rodenja'];
        $korisnik->spol_flag = $entitet['spol_flag'];
        $korisnik->mobilni_telefon = $entitet['mobilni_telefon'];
        $korisnik->fiksni_telefon = $entitet['fiksni_telefon'];
        $korisnik->zanimanje = $entitet['zanimanje'];
        $korisnik->bracni_status_flag = $entitet['bracni_status_flag'];
        $korisnik->prima_obavijesti_flag = $entitet['prima_obavijesti_flag'];
        $korisnik->zeli_aktivno_sudjelovati_flag = $entitet['zeli_aktivno_sudjelovati_flag'];
        $korisnik->potvrdeno_clanstvo_flag = $entitet['potvrdeno_clanstvo_flag'];
        $korisnik->korisnicko_ime = $entitet['korisnicko_ime'];
        //dodaj sol i hash
        $korisnik->lozinka_sol = '';
        $korisnik->lozinka_SHA256 = '';
        $korisnik->email = $entitet['email'];
        $korisnik->datum_vrijeme_registracije = date('Y-m-d H:i:s');
        $korisnik->napomena = $entitet['napomena'];
        $korisnik->radni_interesi = $entitet['radni_interesi'];
        $korisnik->adrese_adresa_id = $entitet['adrese_adresa_id'];
        $korisnik->uloge_uloga_id = $entitet['uloge_uloga_id'];
        $korisnik->korisnici_roditelj_1 = $entitet['korisnici_roditelj_1'];
        $korisnik->korisnici_roditelj_2 = $entitet['korisnici_roditelj_2'];
        

        $korisnik->created_at = date('Y-m-d H:i:s');
        $korisnik->updated_at = date('Y-m-d H:i:s');
        $korisnik->deleted_at = null;

        $korisnik->save();

        return $korisnik;
    }

    /*
     Vraća sve retke iz zadane tablice
    */
    public static function readAll(){
        $korisnik = Korisnik::all();
        return $korisnik;
    }

    /*
     Funkcija mijenja postojeći redak u tablici,
     pomoću id varijable dohvaćenog retka prepoznaje koji red u tablici treba ažurirati
     $entitet je $_POST varijabla
    */
    public static function update(){
        
        $updateUser=$_POST['userID'];
        $prviRoditelj=$_POST['prviRoditelj'];
        $drugiRoditelj=$_POST['drugiRoditelj'];
        //pronadi objekt za update
        $korisnik= Korisnik::findOrFail($updateUser);
        //postavi nove vrijednosti 
        $korisnik->ime = $_POST['fname'];
        $korisnik->prezime = $_POST['lname'];
        $korisnik->oib = $_POST['oib'];
        $korisnik->email = $_POST['email'];
        $korisnik->datum_rodenja = $_POST['birtdate'];
        $korisnik->mobilni_telefon = $_POST['mobilni_telefon'];
        $korisnik->fiksni_telefon = $_POST['fiksni_telefon'];
        $korisnik->zanimanje = $_POST['zanimanje'];
        $korisnik->korisnicko_ime = $_POST['korisnicko_ime'];
        $korisnik->adrese_adresa_id = $_POST['adresa'];
        $korisnik->uloge_uloga_id = $_POST['uloga'];
        $korisnik->updated_at = date('Y-m-d H:i:s');
        /*
        $korisnik->spol_flag = $entitet['spol_flag'];
        $korisnik->bracni_status_flag = $entitet['bracni_status_flag'];
        $korisnik->prima_obavijesti_flag = $entitet['prima_obavijesti_flag'];
        $korisnik->zeli_aktivno_sudjelovati_flag = $entitet['zeli_aktivno_sudjelovati_flag'];
        $korisnik->potvrdeno_clanstvo_flag = $entitet['potvrdeno_clanstvo_flag'];
        //dodaj sol i hash
        $korisnik->lozinka_sol = '';
        $korisnik->lozinka_SHA256 = '';
        $korisnik->datum_vrijeme_registracije = date('Y-m-d H:i:s');
        $korisnik->napomena = $entitet['napomena'];
        $korisnik->radni_interesi = $entitet['radni_interesi'];
        $korisnik->korisnici_roditelj_1 = $entitet['korisnici_roditelj_1'];
        $korisnik->korisnici_roditelj_2 = $entitet['korisnici_roditelj_2'];*/

        //spremi
        $korisnik->save();

        //vrati pogled sa novim podacima
        $podaciDetaljni = PrikazObiteljiController::getUserDataRoles($prviRoditelj,$drugiRoditelj,NULL);
        return view("obitelji.show", $podaciDetaljni);
    }

    /*
     Briše red u tablici sa primarnim ključem primljenim iz parametra $id
    */
    public static function delete($id){
        
        Korisnik::destroy($id);   
    }

    public static function checkIfExistsById($id){
        $exists = false;
        $korisnik= Korisnik::find($id);

        if ($korisnik != NULL) {
            $exists = true;
        }

        return $exists;
    }

    public static function checkIfExistsByEmailAndUsername($email, $username){
        $exists = false;

        $korisnik= Korisnik::where('email', '=', $email)
                        ->where('korisnicko_ime', '=', $username)
                        ->first();

        if ($korisnik != NULL) {
            $exists = true;
        }

        return $exists;
    }
}
