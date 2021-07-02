<?php

namespace App\Http\Controllers\DbControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RazinaOvlasti;

class RazinaOvlastiController extends Controller
{
    public static function insert($entitet){
        $razinaOvlasti = new RazinaOvlasti();


        $razinaOvlasti->kodna_vrijednost = $entitet['kodna_vrijednost'];
        $razinaOvlasti->opis = $entitet['opis_ovlasti'];

        $razinaOvlasti->created_at = date('Y-m-d H:i:s');
        $razinaOvlasti->updated_at = date('Y-m-d H:i:s');
        $razinaOvlasti->deleted_at = null;

        $razinaOvlasti->save();

    }

    /*
     Vraća sve retke iz zadane tablice
    */
    public static function readAll(){
        $razinaOvlasti = RazinaOvlasti::all();
        return $razinaOvlasti;
    }

    public static function getKodnaVrijednostById(int $id){
        $razinaOvlasti = RazinaOvlasti::where('id', $id)->first();
        
        return $razinaOvlasti->kodna_vrijednost;
    }

    /*
     Funkcija mijenja postojeći redak u tablici,
     pomoću id varijable dohvaćenog retka prepoznaje koji red u tablici treba ažurirati
     $entitet je $_POST varijabla
    */
    public static function update($entitet){
        
        $razinaOvlasti = RazinaOvlasti::find($entitet['id']);

        $razinaOvlasti->kodna_vrijednost = $entitet['kodna_vrijednost'];
        $razinaOvlasti->opis = $entitet['opis_ovlasti'];
        
        $razinaOvlasti->updated_at = date('Y-m-d H:i:s');

        $razinaOvlasti->save();

        return $razinaOvlasti;
    }

    /*
     Briše red u tablici sa primarnim ključem primljenim iz parametra $id
    */
    public static function delete($id){
        
        RazinaOvlasti::destroy($id);   
    }
}
