<?php

namespace App\Http\Controllers\DbControllers;

use App\Models\Adresa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdresaController extends Controller
{
    /*
     Funkcija kreaira novi redak u tablici
     $entitet je $_POST varijabla iz koje dohvaćaju vrijednosti atributa te se spremaju u novu ulogu
    */
    public static function insert($entitet){
        $adresa = new Adresa();

        $adresa->ulica_broj = $entitet['ulica'].' '.$entitet['broj'];
        $adresa->ulica_broj_dodatak = $entitet['ulica_broj_dodatak'];
        $adresa->grad_naselje = $entitet['grad_naselje'];
        $adresa->drzava = $entitet['drzava'];
        $adresa->postanski_broj = $entitet['postanski_broj'];
        $adresa->rucni_unos = $entitet['rucni_unos'];
        $adresa->mjesta_id = $entitet['mjesta_id'];
        
        $adresa->created_at = date('Y-m-d H:i:s');
        $adresa->updated_at = date('Y-m-d H:i:s');
        $adresa->deleted_at = null;

        $adresa->save();

    }

    /*
     Vraća sve retke iz zadane tablice
    */
    public static function readAll(){
        $adresa = Adresa::all();
        return $adresa;
    }

    /*
     Funkcija mijenja postojeći redak u tablici,
     pomoću id varijable dohvaćenog retka prepoznaje koji red u tablici treba ažurirati
     $entitet je $_POST varijabla
    */
    public static function update($entitet){
        
        $adresa = Adresa::find($entitet['id']);

        $adresa->ulica_broj = $entitet['ulica'].' '.$entitet['broj'];
        $adresa->ulica_broj_dodatak = $entitet['ulica_broj_dodatak'];
        $adresa->grad_naselje = $entitet['grad_naselje'];
        $adresa->drzava = $entitet['drzava'];
        $adresa->postanski_broj = $entitet['postanski_broj'];
        $adresa->rucni_unos = $entitet['rucni_unos'];
        $adresa->mjesta_id = $entitet['mjesta_id'];

        $adresa->updated_at = date('Y-m-d H:i:s');
        $adresa->save();

    }

    /*
     Briše red u tablici sa primarnim ključem primljenim iz parametra $id
    */
    public static function delete($id){
        
        Adresa::destroy($id);
    }
}
