<?php

namespace App\Http\Controllers\DbControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Uloga;

class UlogaController extends Controller
{

    /*
     Funkcija kreaira novi redak u tablici
     $entitet je $_POST varijabla iz koje dohvaćaju vrijednosti atributa te se spremaju u novu ulogu
    */
    public static function insert($entitet){
        $uloga = new Uloga();

        $uloga->uloga_opis = $entitet['uloga_opis'];

        $uloga->created_at = date('Y-m-d H:i:s');
        $uloga->updated_at = date('Y-m-d H:i:s');
        $uloga->deleted_at = null;

        $uloga->save();


        return $uloga;    
    }

    /*
     Vraća sve retke iz zadane tablice
    */
    public static function readAll(){
        $uloga = Uloga::all();
        return $uloga;
    }

    /*
     Funkcija mijenja postojeći redak u tablici,
     pomoću id varijable dohvaćenog retka prepoznaje koji red u tablici treba ažurirati
     $entitet je $_POST varijabla
    */
    public static function update($entitet){
        
        $uloga = Uloga::find($entitet['id']);

        $uloga->uloga_opis = $entitet['uloga_opis'];
        
        $uloga->updated_at = date('Y-m-d H:i:s');

        $uloga->save();

        return $uloga;
    }

    /*
     Briše red u tablici sa primarnim ključem primljenim iz parametra $id
    */
    public static function delete($id){
        
        Uloga::destroy($id);   
    }
}
