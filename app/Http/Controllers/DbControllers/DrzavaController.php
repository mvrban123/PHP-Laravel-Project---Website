<?php

namespace App\Http\Controllers\DbControllers;

use App\Models\Drzava;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DrzavaController extends Controller
{
    /*
     Funkcija kreaira novi redak u tablici
     $entitet je $_POST varijabla iz koje dohvaćaju vrijednosti atributa te se spremaju u novu ulogu
    */
    public static function insert($entitet){
        $drzava = new Drzava();

        $drzava->naziv = $entitet['naziv_drzave'];

        $drzava->created_at = date('Y-m-d H:i:s');
        $drzava->updated_at = date('Y-m-d H:i:s');
        $drzava->deleted_at = null;

        $drzava->save();

    }

    /*
     Vraća sve retke iz zadane tablice
    */
    public static function readAll(){
        $drzava = Drzava::all();
        return $drzava;
    }

    /*
     Funkcija mijenja postojeći redak u tablici,
     pomoću id varijable dohvaćenog retka prepoznaje koji red u tablici treba ažurirati
     $entitet je $_POST varijabla
    */
    public static function update($entitet){
        
        $drzava = Drzava::find($entitet['id']);

        $drzava->naziv = $entitet['naziv_drzave'];
        $drzava->updated_at = date('Y-m-d H:i:s');
        $drzava->save();

        return $drzava;
    }

    /*
     Briše red u tablici sa primarnim ključem primljenim iz parametra $id
    */
    public static function delete($id){
        
        Drzava::destroy($id);   
    }
}
