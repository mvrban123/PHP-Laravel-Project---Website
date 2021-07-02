<?php

namespace App\Http\Controllers\DbControllers;

use App\Models\Funkcionalnost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FunkcionalnostController extends Controller
{
     /*
     Funkcija kreaira novi redak u tablici
     $entitet je $_POST varijabla iz koje dohvaćaju vrijednosti atributa te se spremaju u novu ulogu
    */
    public static function insert($entitet){
        $funkcionalnost = new Funkcionalnost();

        $funkcionalnost->naziv = $entitet['naziv_funkcionalnosti'];

        $funkcionalnost->created_at = date('Y-m-d H:i:s');
        $funkcionalnost->updated_at = date('Y-m-d H:i:s');
        $funkcionalnost->deleted_at = null;

        $funkcionalnost->save();

    }

     /*
     Vraća sve retke iz zadane tablice
    */
    public static function readAll(){
        $funkcionalnost = Funkcionalnost::all();
        return $funkcionalnost;
    }


    /*
     Vraća funkcionalnost sa zadanim nazivom
    */
    public static function getByNaziv( $naziv ){
        $funkcionalnost = Funkcionalnost::where('naziv', $naziv)->first();
        return $funkcionalnost;
    }

    public static function getNazivById(int $id){
        $funkcionalnost = Funkcionalnost::where('id', $id)->first();
        return (string)$funkcionalnost->naziv;
    }

    /*
     Funkcija mijenja postojeći redak u tablici,
     pomoću id varijable dohvaćenog retka prepoznaje koji red u tablici treba ažurirati
     $entitet je $_POST varijabla
    */
    public static function update($entitet){
        
        $funkcionalnost = Funkcionalnost::find($entitet['id']);

        $funkcionalnost->naziv = $entitet['naziv_funkcionalnosti'];
        $funkcionalnost->updated_at = date('Y-m-d H:i:s');
        $funkcionalnost->save();

        return $funkcionalnost;
    }

    /*
     Briše red u tablici sa primarnim ključem primljenim iz parametra $id
    */
    public static function delete($id){
        
        Funkcionalnost::destroy($id);   
    }
}
