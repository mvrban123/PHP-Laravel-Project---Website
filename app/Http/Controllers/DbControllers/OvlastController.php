<?php

namespace App\Http\Controllers\DbControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ovlast;

class OvlastController extends Controller
{
    /*
     Funkcija kreaira novi redak u tablici
     $entitet je $_POST varijabla iz koje dohvaćaju vrijednosti atributa te se spremaju u novu ulogu
    */
    public static function insert($entitet){
        $ovlast = new Ovlast();

        $ovlast->uloge_id = $entitet['uloge_id'];
        $ovlast->funkcionalnosti_id = $entitet['funkcionalnosti_id'];
        $ovlast->razine_ovlasti_id = $entitet['razine_ovlasti_id'];

        $ovlast->created_at = date('Y-m-d H:i:s');
        $ovlast->updated_at = date('Y-m-d H:i:s');
        $ovlast->deleted_at = null;

        $ovlast->save();

    }

    /*
     Vraća sve retke iz zadane tablice
    */
    public static function readAll(){
        $ovlast = Ovlast::all();
        return $ovlast;
    }

    /*
     Funkcija dohvaća razine_ovlasti_id atribut za proslijeđene paramtere uloge i funkcionalnosti
    */
    public static function getRazineOvlastiByUlogeIdAndFunkcionalnost(int $idUloge, int $idFunkcionalnost){
        
        $ovlast = Ovlast::where('uloge_id', $idUloge)->where('funkcionalnosti_id',$idFunkcionalnost)->first();
        return $ovlast->razine_ovlasti_id;
    }

    public static function getByUloge(int $idUloge){
        
        $ovlast = Ovlast::where('uloge_id', $idUloge)->get();

        return $ovlast;

    }

    /*
     Funkcija mijenja postojeći redak u tablici,
     pomoću id varijable dohvaćenog retka prepoznaje koji red u tablici treba ažurirati
     $entitet je $_POST varijabla
    */
    public static function update($entitet){
        
        $ovlast = Ovlast::find($entitet['id']);

        $ovlast->uloge_id = $entitet['uloge_id'];
        $ovlast->funkcionalnosti_id = $entitet['funkcionalnosti_id'];
        $ovlast->razine_ovlasti_id = $entitet['razine_ovlasti_id'];


        $ovlast->updated_at = date('Y-m-d H:i:s');
        
        $ovlast->save();

        return $ovlast;
    }

    /*
     Briše red u tablici sa primarnim ključem primljenim iz parametra $id
    */
    public static function delete($id){
        
        Ovlast::destroy($id);   
    }
}
