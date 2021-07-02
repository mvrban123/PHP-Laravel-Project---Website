<?php

namespace App\Http\Controllers\DbControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mjesto;

class MjestoController extends Controller
{
    /*
     Funkcija kreaira novi redak u tablici
     $entitet je $_POST varijabla iz koje dohvaćaju vrijednosti atributa te se spremaju u novu ulogu
    */
    public static function insert($entitet){
        $mjesto = new Mjesto();

        $mjesto->naziv = $entitet['naziv_mjesta'];
        $mjesto->postanski_broj = $entitet['postanski_broj'];
        $mjesto->drzave_id = $entitet['drzave_id'];
        

        $mjesto->created_at = date('Y-m-d H:i:s');
        $mjesto->updated_at = date('Y-m-d H:i:s');
        $mjesto->deleted_at = null;

        $mjesto->save();

    }
    /*
     Vraća sve retke iz zadane tablice
    */
    public static function readAll(){
        $mjesto = Mjesto::all();
        return $mjesto;
    }

    /*
     Funkcija mijenja postojeći redak u tablici,
     pomoću id varijable dohvaćenog retka prepoznaje koji red u tablici treba ažurirati
     $entitet je $_POST varijabla
    */
    public static function update($entitet){
        
        $mjesto = Mjesto::find($entitet['id']);

        $mjesto->naziv = $entitet['naziv_mjesta'];
        $mjesto->postanski_broj = $entitet['postanski_broj'];
        $mjesto->drzave_id = $entitet['drzave_id'];

        $mjesto->updated_at = date('Y-m-d H:i:s');
        
        $mjesto->save();

        return $mjesto;
    }

    /*
     Briše red u tablici sa primarnim ključem primljenim iz parametra $id
    */
    public static function delete($id){
        
        Mjesto::destroy($id);   
    }
}
