<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Korisnik;
use App\Models\Uloga;

define('family','/app/Models/Korisnik');

class PrikazObiteljiController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function getRoditelji()
    {
        //$data = Korisnik::where('korisnici_roditelj_1','=',NULL)->get();
        //$data = Korisnik::all();
        $dvaRoditelja=\DB::select('SELECT DISTINCT 
                                   k1.korisnici_roditelj_1, k2.korisnici_roditelj_2,
                                   k1.prezime as prvi_roditelj_prezime, k1.ime as prvi_roditelj_ime,
                                   k2.prezime as drugi_roditelj_prezime, k2.ime as drugi_roditelj_ime
                                   FROM korisnici k1, korisnici k2 
                                   WHERE (k1.korisnici_roditelj_1 = k2.korisnici_roditelj_1 
                                   AND k1.korisnici_roditelj_2 = k2.korisnici_roditelj_2)
        ');
        
        $jedanRoditelj=\DB::select('SELECT DISTINCT 
                                    k1.korisnici_roditelj_1, k2.korisnici_roditelj_2,
                                    k1.prezime as prvi_roditelj_prezime, k1.ime as prvi_roditelj_ime,
                                    k2.prezime as drugi_roditelj_prezime, k2.ime as drugi_roditelj_ime
                                    FROM korisnici k1, korisnici k2 
                                    WHERE (k1.korisnici_roditelj_1 = k2.korisnici_roditelj_1 
                                    AND k1.korisnici_roditelj_2 is NULL)');

        $dvaRoditelja=json_decode(json_encode($dvaRoditelja),true);
        $jedanRoditelj=json_decode(json_encode($jedanRoditelj),true);

        $data3=array_merge($dvaRoditelja,$jedanRoditelj);

        $data3=array_unique($data3, SORT_REGULAR);

        return compact(['data3']);
        
    }
    
    public static function getUserDataRoles($user, $user2 = NULL, $detailedUser = NULL,$getEmails = NULL)
    {
        $prviRoditelj=$user;
        if($user2==NULL){
            $drugiRoditelj=0;
        }
        else{
            $drugiRoditelj=$user2;
        }
        if($user2==0){
            $data=Korisnik::
                  where('korisnici_roditelj_1','=', $user)
                  ->orWhere('korisnici_roditelj_2','=', $user)
                  ->orWhere('id','=',$user)
                  ->get();
        }
        else{
            $data=Korisnik::
                  where('korisnici_roditelj_1','=', $user)->
                  Where('korisnici_roditelj_2','=', $user2)
                  ->orWhere('id','=',$user)->orWhere('id','=',$user2)->orderBy('id')
                  ->get();
        }

        $roles=Uloga::all();
        
        $userCount=0;
        
        foreach($data as $family){
            if($family['korisnici_roditelj_1']==$user || $family['id']==$user || $family['id']==$user2 || $family['korisnici_roditelj_2']==$user2)
                $userCount++;
            /*if($family['korisnici_roditelj_1']==$user){
                $prviRoditelj=$family['korisnici_roditelj_1'];
            }
            if($family['korisnici_roditelj_2']==$user2){
                $drugiRoditelj=$family['korisnici_roditelj_2'];
            */
        }

        $detaljanPrikazClana=NULL;
        $detailUser=NULL;
        $sveAdrese=NULL;
        if($detailedUser || $detailedUser!=0){
            $detaljanPrikazClana=\DB::select('select * from korisnici k where k.id='.$detailedUser);
            $sveAdrese=\DB::select('SELECT a.id,a.ulica_broj,a.ulica_broj_dodatak,m.naziv,d.naziv as drzava from adrese a 
                                    join mjesta m on a.mjesta_id=m.id 
                                    join drzave d on m.drzave_id=d.id ');
            $detaljanPrikazClana=json_decode(json_encode($detaljanPrikazClana),true);
            $sveAdrese=json_decode(json_encode($sveAdrese),true);
            $detailUser=$detaljanPrikazClana[0]['id'];
        }

        $obiteljskiMailovi=array();

        if($getEmails!=NULL){
            $obiteljskiMailovi=\DB::select("select e.*,
                                Concat(k1.ime,' ',k1.prezime) as primatelj,
                                Concat(k2.ime,' ',k2.prezime) as posiljatelj,em.putanja 
                                from email_poruke e 
                                join korisnici k1 on k1.id=e.to_korisnici_id 
                                join korisnici k2 on k2.id=e.from_korisnici_id 
                                left join email_prilozi em on em.id=e.email_prilozi_id 
                                where e.to_korisnici_id=".$prviRoditelj. 
                                " OR e.to_korisnici_id=".$drugiRoditelj. " ORDER BY e.to_korisnici_id");

            $obiteljskiMailovi=json_decode(json_encode($obiteljskiMailovi),true);

            

            foreach ($obiteljskiMailovi as $key => $val) {
                $var = html_entity_decode($val['tijelo']);
                $obiteljskiMailovi[$key]['tijelo'] = $var;
                // var_dump($obiteljskiMailovi);
                // var_dump($var);
            }            
        }
        

        return compact('userCount','data','roles','prviRoditelj','drugiRoditelj','detaljanPrikazClana','sveAdrese','detailUser','obiteljskiMailovi');
    }
}
