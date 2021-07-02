<?php

namespace App\Http\Controllers\DbControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RazinaObrazovanja;

class RazinaObrazovanjaController extends Controller
{

    /*
     Funkcija kreaira novi redak u tablici
     $entitet je $_POST varijabla iz koje dohvaćaju vrijednosti atributa te se spremaju u novu ulogu
    */
    public static function insert($entitet){
        $razinaObrazovanja = new RazinaObrazovanja();

        $razinaObrazovanja->razina_obrazovanja_opis = $entitet['razina_obrazovanja_opis'];

        $razinaObrazovanja->created_at = date('Y-m-d H:i:s');
        $razinaObrazovanja->updated_at = date('Y-m-d H:i:s');
        $razinaObrazovanja->deleted_at = null;

        $razinaObrazovanja->save();

    }
    /*
     Vraća sve retke iz zadane tablice
    */
    public static function readAll(){
        $razinaObrazovanja = RazinaObrazovanja::all();
        return $razinaObrazovanja;
    }

    /*
     Funkcija mijenja postojeći redak u tablici,
     pomoću id varijable dohvaćenog retka prepoznaje koji red u tablici treba ažurirati
     $entitet je $_POST varijabla
    */
    public static function update($entitet){
        
        $razinaObrazovanja = RazinaObrazovanja::find($entitet['id']);

        $razinaObrazovanja->razina_obrazovanja_opis = $entitet['razina_obrazovanja_opis'];
        
        $razinaObrazovanja->updated_at = date('Y-m-d H:i:s');

        $razinaObrazovanja->save();

        return $razinaObrazovanja;
    }

    /*
     Briše red u tablici sa primarnim ključem primljenim iz parametra $id
    */
    public static function delete($id){
        
        RazinaObrazovanja::destroy($id);   
    }
}
