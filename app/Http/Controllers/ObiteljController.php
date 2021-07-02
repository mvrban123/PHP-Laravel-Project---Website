<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Korisnik;
use App\Models\Uloga;
use App\Models\Mjesto;
use App\Models\Drzava;
use App\Models\Adresa;
use App\Http\Sanitizers\BaseSanitizer;



class ObiteljController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $gradovi = Mjesto::all();
        $drzave = Drzava::all();
        $filterDrzava=0;
        $filterGrad = 0;
        $filterStatusRoditelja=0;
        $filterIspunjenjeUvjeta=0;
/*
        $dvaRoditelja=\DB::select('SELECT DISTINCT 
                        k1.korisnici_roditelj_1, k2.korisnici_roditelj_2
                        FROM korisnici k1, korisnici k2 
                        WHERE (k1.korisnici_roditelj_1 = k2.korisnici_roditelj_1 
                        AND k1.korisnici_roditelj_2 = k2.korisnici_roditelj_2)');

        $jedanRoditelj=\DB::select('SELECT DISTINCT
                        k1.korisnici_roditelj_1, k2.korisnici_roditelj_2
                        FROM korisnici k1, korisnici k2 
                        WHERE (k1.korisnici_roditelj_1 = k2.korisnici_roditelj_1 
                        AND k1.korisnici_roditelj_2 is NULL)');

        $dvaRoditelja=json_decode(json_encode($dvaRoditelja),true);
        $jedanRoditelj=json_decode(json_encode($jedanRoditelj),true);

        $data4=array_merge($dvaRoditelja,$jedanRoditelj);

        $data4=array_unique($data4, SORT_REGULAR);

        $i=0;
        $data3 = array();

        foreach($data4 as $dat){
            if($dat['korisnici_roditelj_2']!=NULL){
                $obaRoditelja=Korisnik::where('id','=',$dat['korisnici_roditelj_1'])->orWhere('id','=',$dat['korisnici_roditelj_2'])->get();
                foreach($obaRoditelja as $roditelj){
                    if($dat['korisnici_roditelj_1']==$roditelj['id']){
                        $data3[$i]['prvi_roditelj_id']=$roditelj['id'];
                        $data3[$i]['prvi_roditelj_ime']=$roditelj['ime'];
                        $data3[$i]['prvi_roditelj_prezime']=$roditelj['prezime'];
                        $data3[$i]['prvi_roditelj_email']=$roditelj['email'];
                    }
                    else{
                        $data3[$i]['drugi_roditelj_id']=$roditelj['id'];
                        $data3[$i]['drugi_roditelj_ime']=$roditelj['ime'];
                        $data3[$i]['drugi_roditelj_prezime']=$roditelj['prezime'];
                        $data3[$i]['drugi_roditelj_email']=$roditelj['email'];
                    }
                }
                $i++;
            }
            else{
                $jedanRoditelj=Korisnik::where('id','=',$dat['korisnici_roditelj_1'])->get();
                foreach($jedanRoditelj as $roditelj){
                    $data3[$i]['prvi_roditelj_id']=$roditelj['id'];
                    $data3[$i]['prvi_roditelj_ime']=$roditelj['ime'];
                    $data3[$i]['prvi_roditelj_prezime']=$roditelj['prezime'];
                    $data3[$i]['prvi_roditelj_email']=$roditelj['email'];
                    $data3[$i]['drugi_roditelj_id']=NULL;
                    $data3[$i]['drugi_roditelj_ime']=NULL;
                    $data3[$i]['drugi_roditelj_prezime']=NULL;
                    $data3[$i]['drugi_roditelj_email']=NULL;
                    $i++;
                }
            }
        }

        return view('obitelji.index', compact('data3','drzave','gradovi','filterDrzava','filterGrad','filterStatusRoditelja','filterIspunjenjeUvjeta'));*/

        /* Fetch families*/
        $brojClanovaPoObitelji=\DB::select('select o.id,count(k.id) as clanovi 
                                            from korisnici k join obiteljski_identifikatori o on k.obiteljski_identifikatori_id=o.id 
                                            where k.uloge_uloga_id!=3 group by 1');
        $brojClanovaPoObitelji=json_decode(json_encode($brojClanovaPoObitelji),true);

        $roditelji=array();
        $i=0;
        foreach($brojClanovaPoObitelji as $brojClanova){
            if($brojClanova['clanovi']==2){
                $obitelj=\DB::select("SELECT distinct o.id,k1.id as prvi_roditelj_id,concat(k1.ime,' ',k1.prezime) as prvi_roditelj,k2.id as drugi_roditelj_id, concat(k2.ime,' ',k2.prezime) as drugi_roditelj
                                     from korisnici k1 
                                     join obiteljski_identifikatori o on k1.obiteljski_identifikatori_id=o.id 
                                     join korisnici k2 on k2.obiteljski_identifikatori_id=o.id 
                                     WHERE (k1.uloge_uloga_id != 3 
                                     AND k2.uloge_uloga_id != 3 
                                     AND o.id=".$brojClanova['id']." AND k1.id!=k2.id AND k2.id!=k1.id) order by k1.id");
                $obitelj=json_decode(json_encode($obitelj),true);
                for($j=0;$j<1;$j++){
                    $roditelji[$i]['prviRoditeljId']=$obitelj[$j]['prvi_roditelj_id'];
                    $roditelji[$i]['prviRoditeljIme']=$obitelj[$j]['prvi_roditelj'];
                    $roditelji[$i]['drugiRoditeljId']=$obitelj[$j]['drugi_roditelj_id'];
                    $roditelji[$i]['drugiRoditeljIme']=$obitelj[$j]['drugi_roditelj'];
                }
                $i++;
            }
            else{
                $obitelj=\DB::select("SELECT distinct o.id,k1.id as prvi_roditelj_id,concat(k1.ime,' ',k1.prezime) as prvi_roditelj
                                      from korisnici k1 join obiteljski_identifikatori o on k1.obiteljski_identifikatori_id=o.id  
                                      WHERE (k1.uloge_uloga_id != 3 AND 
                                      o.id=".$brojClanova['id'].")");
                $obitelj=json_decode(json_encode($obitelj),true);
                for($j=0;$j<1;$j++){
                    $roditelji[$i]['prviRoditeljId']=$obitelj[$j]['prvi_roditelj_id'];
                    $roditelji[$i]['prviRoditeljIme']=$obitelj[$j]['prvi_roditelj'];
                    $roditelji[$i]['drugiRoditeljId']=NULL;
                    $roditelji[$i]['drugiRoditeljIme']=NULL;
                    }
                $i++;
            }
        }
        $roditelji=json_decode(json_encode($roditelji),true);
        $data3=$roditelji;

        /*End fetch families*/


        return view('obitelji.index', compact('data3'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function detaljniPrikazObitelji($user, $user2 = NULL,$detailedUser = NULL,$getEmails = NULL)
    {
        $podaciDetaljni = PrikazObiteljiController::getUserDataRoles($user,$user2,$detailedUser,$getEmails);

        return view("obitelji.show", $podaciDetaljni);
    }

    public function deleteAUser($user, $user2 = NULL,$detailedUser1=null){
        //$query='DELETE from korisnici where id='.$detailedUser1;
        
        $deleted=\DB::delete("DELETE from korisnici where id=".$detailedUser1);

        //Korisnik::destroy($detailedUser1);  

        $podaciDetaljni = PrikazObiteljiController::getUserDataRoles($user,$user2);

        return view("obitelji.show", $podaciDetaljni);
    }


    public function filtriraniObiteljskiPodaci(Request $request){
        $input = BaseSanitizer::sanitize($request->all());

        $brojClanovaPoObitelji=\DB::select('select o.id,count(k.id) as clanovi 
        from korisnici k join obiteljski_identifikatori o on k.obiteljski_identifikatori_id=o.id 
        where k.uloge_uloga_id!=3 group by 1');
        $brojClanovaPoObitelji=json_decode(json_encode($brojClanovaPoObitelji),true);

        $dodatniFilteriZaObaRoditelja="(";
        $dodatniFilteriZaJednogRoditelja="(";

        $filterBrojaClanova=NULL;

        /*if($input[0]!=NULL){
            if($input[0]['restrikcija']=="lt"){
                $filterBrojaClanova="<".$input[0]['tekst'];
            }
            else if($input[0]['restrikcija']=="lte"){
                $filterBrojaClanova="<=".$input[0]['tekst'];
            }
            else{
                $filterBrojaClanova=$input[0]['restrikcija'].$input[0]['tekst'];
            }
        }*/
        /*for($i=1;$i<count($input);$i++){
            if($input[$i]["filter"]=="brojClanova"){
                if($input[$i]['restrikcija']=="lt"){
                    $filterBrojaClanova="<".$input[$i]['tekst'];
                }
                else if($input[$i]['restrikcija']=="lte"){
                    $filterBrojaClanova="<=".$input[$i]['tekst'];
                }
                else{
                    $filterBrojaClanova=$input[$i]['restrikcija'].$input[$i]['tekst'];
                }
                unset($input[$i]);
            }
        }*/

        if(count($input)>1){
            if($input[0]['filter']=="ILI"){           
            for($i=1;$i<count($input);$i++){
                if($input[$i]['filter']=="brojClanova"){
                    if($input[$i]['restrikcija']=="lt"){
                        $filterBrojaClanova="<".$input[$i]['tekst'];
                    }
                    else if($input[$i]['restrikcija']=="lte"){
                        $filterBrojaClanova="<=".$input[$i]['tekst'];
                    }
                    else{
                        $filterBrojaClanova=$input[$i]['restrikcija'].$input[$i]['tekst'];
                    }
                    continue;
                }
                if(strlen($dodatniFilteriZaJednogRoditelja)==1 && strlen($dodatniFilteriZaObaRoditelja)==1){
                    //dodavanje prvog uvjeta u upit
                    if($input[$i]['filter']=='zanimanje'){
                        //ovaj i sljedeci uvjet su za pretrazivanje stringova dok je u elsu uvjet za usporedbu datuma i numerickih vrijednosti    
                        $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'k1.'.$input[$i]['filter']." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                        $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'OR k2.'.$input[$i]['filter']." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                        
                        $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'k1.'.$input[$i]['filter']." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                    }
                    else if($input[$i]['filter']=='gradStanovanja'){
                        //tu se dodaje restrikcija za oba roditelja od jednom dok u ostalim primjerima se dodaje prvo za jednog pa onda za drugog roditelj
                        $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'a1.grad_naselje'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' OR "
                                                                                   .'a2.grad_naselje'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' OR "
                                                                                   .'m1.naziv'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' OR "
                                                                                   .'m2.naziv'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'    ";

                        
                        $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'a.grad_naselje'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' OR "
                                                                                         .'m.naziv'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                    }
                    else{
                        if($input[$i]['restrikcija']=="lt"){
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'k1.'.$input[$i]['filter']."<'".$input[$i]['tekst']."'   ";
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'OR k2.'.$input[$i]['filter']."<'".$input[$i]['tekst']."'   ";
                            
                            $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'k1.'.$input[$i]['filter']."<'".$input[$i]['tekst']."'   ";
                        }
                        else if($input[$i]['restrikcija']=="lte"){
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'k1.'.$input[$i]['filter']."<='".$input[$i]['tekst']."'   ";
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'OR k2.'.$input[$i]['filter']."<='".$input[$i]['tekst']."'   ";
                            
                            $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'k1.'.$input[$i]['filter']."<='".$input[$i]['tekst']."'   ";
                        }
                        else{
                            //dodavanje svih ostalih uvjeta osim '<' i '<='
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'k1.'.$input[$i]['filter'].$input[$i]['restrikcija']."'".$input[$i]['tekst']."'   ";
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'OR k2.'.$input[$i]['filter'].$input[$i]['restrikcija']."'".$input[$i]['tekst']."'   ";
                            
                            $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'k1.'.$input[$i]['filter'].$input[$i]['restrikcija']."'".$input[$i]['tekst']."'   ";
                        }
                    }
                }
                else{
                    //iz nekog razloga ne cita iz reda znak '<' i '<=' pa su zato ovi uvjeti tu...
                    //dodavanje svih sljedecih uvjeta u upit nakon prvog
                    if($input[$i]['filter']=='zanimanje'){
                        //ovaj i sljedeci uvjet su za pretrazivanje stringova dok je u elsu uvjet za usporedbu datuma i numerickih vrijednosti     
                        $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'OR k1.'.$input[$i]['filter']." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                        $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'OR k2.'.$input[$i]['filter']." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                        
                        $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'OR k1.'.$input[$i]['filter']." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                    }
                    else if($input[$i]['filter']=='gradStanovanja'){
                        $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'OR a1.grad_naselje'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' OR "
                                                                                   .'a2.grad_naselje'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' OR "
                                                                                   .'m1.naziv'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' OR "
                                                                                   .'m2.naziv'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'    ";

                        $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'OR a.grad_naselje'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' OR "
                                                                                         .'m.naziv'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                    }
                    else{
                        //iz nekog razloga ne cita iz reda znak '<' i '<=' pa su zato ovi uvjeti tu...
                        //dodavanje svih ostalih uvjeta osim '<' i '<='
                        if($input[$i]['restrikcija']=="lt"){
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'OR k1.'.$input[$i]['filter']."<'".$input[$i]['tekst']."'   ";
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'OR k2.'.$input[$i]['filter']."<'".$input[$i]['tekst']."'   ";
                            
                            $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'OR k1.'.$input[$i]['filter']."<'".$input[$i]['tekst']."'   ";
                        }
                        else if($input[$i]['restrikcija']=="lte"){
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'OR k1.'.$input[$i]['filter']."<='".$input[$i]['tekst']."'   ";
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'OR k2.'.$input[$i]['filter']."<='".$input[$i]['tekst']."'   ";
                            
                            $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'OR k1.'.$input[$i]['filter']."<='".$input[$i]['tekst']."'   ";
                        }
                        else{

                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'OR k1.'.$input[$i]['filter'].$input[$i]['restrikcija']."'".$input[$i]['tekst']."'   ";
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'OR k2.'.$input[$i]['filter'].$input[$i]['restrikcija']."'".$input[$i]['tekst']."'   ";
                            
                            $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'OR k1.'.$input[$i]['filter'].$input[$i]['restrikcija']."'".$input[$i]['tekst']."'   ";
                        }
                    }
                }
            }
        }
        else{
            if(count($input)>1){
                for($i=1;$i<count($input);$i++){
                    if($input[$i]['filter']=="brojClanova"){
                        if($input[$i]['restrikcija']=="lt"){
                            $filterBrojaClanova="<".$input[$i]['tekst'];
                        }
                        else if($input[$i]['restrikcija']=="lte"){
                            $filterBrojaClanova="<=".$input[$i]['tekst'];
                        }
                        else{
                            $filterBrojaClanova=$input[$i]['restrikcija'].$input[$i]['tekst'];
                        }
                        continue;
                    }
                    if(strlen($dodatniFilteriZaJednogRoditelja)==1 && strlen($dodatniFilteriZaObaRoditelja)==1){
                        //dodavanje prvog uvjeta u upit
                        if($input[$i]['filter']=='zanimanje'){
                            //ovaj i sljedeci uvjet su za pretrazivanje stringova dok je u elsu uvjet za uspANDedbu datuma i numerickih vrijednosti    
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'k1.'.$input[$i]['filter']." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'AND k2.'.$input[$i]['filter']." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                            
                            $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'k1.'.$input[$i]['filter']." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                        }
                        else if($input[$i]['filter']=='gradStanovanja'){
                            //tu se dodaje restrikcija za oba roditelja od jednom dok u ostalim primjerima se dodaje prvo za jednog pa onda za drugog roditelj
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'a1.grad_naselje'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' AND "
                                                                                       .'a2.grad_naselje'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' AND "
                                                                                       .'m1.naziv'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' AND "
                                                                                       .'m2.naziv'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'    ";
    
                            
                            $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'a.grad_naselje'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' AND "
                                                                                             .'m.naziv'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                        }
                        else{
                            if($input[$i]['restrikcija']=="lt"){
                                $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'k1.'.$input[$i]['filter']."<'".$input[$i]['tekst']."'   ";
                                $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'AND k2.'.$input[$i]['filter']."<'".$input[$i]['tekst']."'   ";
                                
                                $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'k1.'.$input[$i]['filter']."<'".$input[$i]['tekst']."'   ";
                            }
                            else if($input[$i]['restrikcija']=="lte"){
                                $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'k1.'.$input[$i]['filter']."<='".$input[$i]['tekst']."'   ";
                                $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'AND k2.'.$input[$i]['filter']."<='".$input[$i]['tekst']."'   ";
                                
                                $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'k1.'.$input[$i]['filter']."<='".$input[$i]['tekst']."'   ";
                            }
                            else{
                                //dodavanje svih ostalih uvjeta osim '<' i '<='
                                $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'k1.'.$input[$i]['filter'].$input[$i]['restrikcija']."'".$input[$i]['tekst']."'   ";
                                $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'AND k2.'.$input[$i]['filter'].$input[$i]['restrikcija']."'".$input[$i]['tekst']."'   ";
                                
                                $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'k1.'.$input[$i]['filter'].$input[$i]['restrikcija']."'".$input[$i]['tekst']."'   ";
                            }
                        }
                    }
                    else{
                        //iz nekog razloga ne cita iz reda znak '<' i '<=' pa su zato ovi uvjeti tu...
                        //dodavanje svih sljedecih uvjeta u upit nakon prvog
                        if($input[$i]['filter']=='zanimanje'){
                            //ovaj i sljedeci uvjet su za pretrazivanje stringova dok je u elsu uvjet za uspANDedbu datuma i numerickih vrijednosti     
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'AND k1.'.$input[$i]['filter']." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'AND k2.'.$input[$i]['filter']." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                            
                            $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'AND k1.'.$input[$i]['filter']." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                        }
                        else if($input[$i]['filter']=='gradStanovanja'){
                            $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'AND a1.grad_naselje'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' AND "
                                                                                       .'a2.grad_naselje'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' AND "
                                                                                       .'m1.naziv'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' AND "
                                                                                       .'m2.naziv'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'    ";
    
                            $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'AND a.grad_naselje'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%' AND "
                                                                                             .'m.naziv'." ".$input[$i]['restrikcija']." '%".$input[$i]['tekst']."%'   ";
                        }
                        else{
                            //iz nekog razloga ne cita iz reda znak '<' i '<=' pa su zato ovi uvjeti tu...
                            //dodavanje svih ostalih uvjeta osim '<' i '<='
                            if($input[$i]['restrikcija']=="lt"){
                                $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'AND k1.'.$input[$i]['filter']."<'".$input[$i]['tekst']."'   ";
                                $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'AND k2.'.$input[$i]['filter']."<'".$input[$i]['tekst']."'   ";
                                
                                $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'AND k1.'.$input[$i]['filter']."<'".$input[$i]['tekst']."'   ";
                            }
                            else if($input[$i]['restrikcija']=="lte"){
                                $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'AND k1.'.$input[$i]['filter']."<='".$input[$i]['tekst']."'   ";
                                $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'AND k2.'.$input[$i]['filter']."<='".$input[$i]['tekst']."'   ";
                                
                                $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'AND k1.'.$input[$i]['filter']."<='".$input[$i]['tekst']."'   ";
                            }
                            else{
    
                                $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'AND k1.'.$input[$i]['filter'].$input[$i]['restrikcija']."'".$input[$i]['tekst']."'   ";
                                $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.'AND k2.'.$input[$i]['filter'].$input[$i]['restrikcija']."'".$input[$i]['tekst']."'   ";
                                
                                $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.'AND k1.'.$input[$i]['filter'].$input[$i]['restrikcija']."'".$input[$i]['tekst']."'   ";
                            }
                        }
                    }
                }
            }
        }
    }

    if(strlen($dodatniFilteriZaObaRoditelja)>1 && strlen($dodatniFilteriZaJednogRoditelja)>1){
        $dodatniFilteriZaObaRoditelja=$dodatniFilteriZaObaRoditelja.")";
        $dodatniFilteriZaJednogRoditelja=$dodatniFilteriZaJednogRoditelja.")";
    }

        $roditelji=array();
        $i=0;
        foreach($brojClanovaPoObitelji as $brojClanova){
            if($brojClanova['clanovi']==2){
                if(strlen($dodatniFilteriZaObaRoditelja)>2){
                    //izvrsava se upit ako postoje uvjeti pretrazivanja
                    if($filterBrojaClanova){
                        $obitelj=\DB::select("SELECT distinct o.id,k1.id as prvi_roditelj_id,concat(k1.ime,' ',k1.prezime) as prvi_roditelj,
                        k2.id as drugi_roditelj_id, concat(k2.ime,' ',k2.prezime) as drugi_roditelj,
                        (select count(k.id) as clanovi from korisnici k 
                        join obiteljski_identifikatori o on k.obiteljski_identifikatori_id=o.id 
                        where o.id=".$brojClanova['id']." group by k.obiteljski_identifikatori_id) as broj_clanova
                        from korisnici k1 
                        join obiteljski_identifikatori o on k1.obiteljski_identifikatori_id=o.id 
                        join korisnici k2 on k2.obiteljski_identifikatori_id=o.id
                        join adrese a1 on k1.adrese_adresa_id=a1.id
                        join adrese a2 on k2.adrese_adresa_id=a2.id
                        LEFT JOIN mjesta m1 on a1.mjesta_id=m1.id
                        LEFT JOIN mjesta m2 on a2.mjesta_id=m2.id 
                        WHERE (k1.uloge_uloga_id != 3 
                        AND k2.uloge_uloga_id != 3 
                        AND o.id=".$brojClanova['id']." AND k1.id!=k2.id AND k2.id!=k1.id) AND ".$dodatniFilteriZaObaRoditelja. 
                        " AND ((select count(k.id) as clanovi from korisnici k 
                        join obiteljski_identifikatori o on k.obiteljski_identifikatori_id=o.id 
                        where o.id=".$brojClanova['id']." group by k.obiteljski_identifikatori_id)".$filterBrojaClanova.
                        ") order by k1.id");

                        
                    }
                    else{
                        $obitelj=\DB::select("SELECT distinct o.id,k1.id as prvi_roditelj_id,concat(k1.ime,' ',k1.prezime) as prvi_roditelj,
                                    k2.id as drugi_roditelj_id, concat(k2.ime,' ',k2.prezime) as drugi_roditelj,
                                    (select count(k.id) as clanovi from korisnici k 
                                    join obiteljski_identifikatori o on k.obiteljski_identifikatori_id=o.id 
                                    where o.id=".$brojClanova['id']." group by k.obiteljski_identifikatori_id) as broj_clanova
                                    from korisnici k1 
                                    join obiteljski_identifikatori o on k1.obiteljski_identifikatori_id=o.id 
                                    join korisnici k2 on k2.obiteljski_identifikatori_id=o.id
                                    join adrese a1 on k1.adrese_adresa_id=a1.id
                                    join adrese a2 on k2.adrese_adresa_id=a2.id
                                    LEFT JOIN mjesta m1 on a1.mjesta_id=m1.id
                                    LEFT JOIN mjesta m2 on a2.mjesta_id=m2.id 
                                    WHERE (k1.uloge_uloga_id != 3 
                                    AND k2.uloge_uloga_id != 3 
                                    AND o.id=".$brojClanova['id']." AND k1.id!=k2.id AND k2.id!=k1.id) AND ".$dodatniFilteriZaObaRoditelja." order by k1.id");
                    }
                    $obitelj=json_decode(json_encode($obitelj),true);
                }
                else{
                    //izvrsava se upit ako ne postoje uvjeti pretrazivanja
                    if($filterBrojaClanova){
                        $obitelj=\DB::select("SELECT distinct o.id,k1.id as prvi_roditelj_id,concat(k1.ime,' ',k1.prezime) as prvi_roditelj,
                                    k2.id as drugi_roditelj_id, concat(k2.ime,' ',k2.prezime) as drugi_roditelj,
                                    (select count(k.id) as clanovi from korisnici k 
                                    join obiteljski_identifikatori o on k.obiteljski_identifikatori_id=o.id 
                                    where o.id=".$brojClanova['id']." group by k.obiteljski_identifikatori_id) as broj_clanova
                                    from korisnici k1 
                                    join obiteljski_identifikatori o on k1.obiteljski_identifikatori_id=o.id 
                                    join korisnici k2 on k2.obiteljski_identifikatori_id=o.id
                                    join adrese a1 on k1.adrese_adresa_id=a1.id
                                    join adrese a2 on k2.adrese_adresa_id=a2.id
                                    LEFT JOIN mjesta m1 on a1.mjesta_id=m1.id
                                    LEFT JOIN mjesta m2 on a2.mjesta_id=m2.id 
                                    WHERE (k1.uloge_uloga_id != 3 
                                    AND k2.uloge_uloga_id != 3 
                                    AND o.id=".$brojClanova['id']." AND k1.id!=k2.id AND k2.id!=k1.id)".
                                    " AND ((select count(k.id) as clanovi from korisnici k 
                                    join obiteljski_identifikatori o on k.obiteljski_identifikatori_id=o.id 
                                    where o.id=".$brojClanova['id']." group by k.obiteljski_identifikatori_id)".$filterBrojaClanova.
                                    ") order by k1.id");
                    }
                    else{
                        $obitelj=\DB::select("SELECT distinct o.id,k1.id as prvi_roditelj_id,concat(k1.ime,' ',k1.prezime) as prvi_roditelj,
                                    k2.id as drugi_roditelj_id, concat(k2.ime,' ',k2.prezime) as drugi_roditelj,
                                    (select count(k.id) as clanovi from korisnici k 
                                    join obiteljski_identifikatori o on k.obiteljski_identifikatori_id=o.id 
                                    where o.id=".$brojClanova['id']." group by k.obiteljski_identifikatori_id) as broj_clanova
                                    from korisnici k1 
                                    join obiteljski_identifikatori o on k1.obiteljski_identifikatori_id=o.id 
                                    join korisnici k2 on k2.obiteljski_identifikatori_id=o.id
                                    join adrese a1 on k1.adrese_adresa_id=a1.id
                                    join adrese a2 on k2.adrese_adresa_id=a2.id
                                    LEFT JOIN mjesta m1 on a1.mjesta_id=m1.id
                                    LEFT JOIN mjesta m2 on a2.mjesta_id=m2.id 
                                    WHERE (k1.uloge_uloga_id != 3 
                                    AND k2.uloge_uloga_id != 3 
                                    AND o.id=".$brojClanova['id']." AND k1.id!=k2.id AND k2.id!=k1.id) order by k1.id");
                    }
                    $obitelj=json_decode(json_encode($obitelj),true);
                }
                for($j=0;$j<1;$j++){
                    if(count($obitelj)>0){
                        $roditelji[$i]['prviRoditeljId']=$obitelj[$j]['prvi_roditelj_id'];
                        $roditelji[$i]['prviRoditeljIme']=$obitelj[$j]['prvi_roditelj'];
                        $roditelji[$i]['drugiRoditeljId']=$obitelj[$j]['drugi_roditelj_id'];
                        $roditelji[$i]['drugiRoditeljIme']=$obitelj[$j]['drugi_roditelj'];
                        $roditelji[$i]['broj_clanova']=$obitelj[$j]['broj_clanova'];
                    }
                }
                $i++;
            }
            else{
                if(strlen($dodatniFilteriZaJednogRoditelja)>=2){
                    //izvrsava se upit ako postoje uvjeti pretrazivanja
                    $obitelj=\DB::select("SELECT distinct o.id,k1.id as prvi_roditelj_id,concat(k1.ime,' ',k1.prezime) as prvi_roditelj,
                                    (select count(k.id) as clanovi from korisnici k 
                                    join obiteljski_identifikatori o on k.obiteljski_identifikatori_id=o.id 
                                    where o.id=".$brojClanova['id']." group by k.obiteljski_identifikatori_id) as broj_clanova
                                    from korisnici k1 
                                    join obiteljski_identifikatori o on k1.obiteljski_identifikatori_id=o.id
                                    join adrese a on k1.adrese_adresa_id=a.id
                                    left join mjesta m on a.mjesta_id=m.id  
                                    WHERE (k1.uloge_uloga_id != 3 AND k1.bracni_status_flag=0 AND
                                    o.id=".$brojClanova['id'].") AND ".$dodatniFilteriZaJednogRoditelja);
                    $obitelj=json_decode(json_encode($obitelj),true);
                }
                else{
                    //izvrsava se upit ako ne postoje uvjeti pretrazivanja
                    $obitelj=\DB::select("SELECT distinct o.id,k1.id as prvi_roditelj_id,concat(k1.ime,' ',k1.prezime) as prvi_roditelj,
                                    (select count(k.id) as clanovi from korisnici k 
                                    join obiteljski_identifikatori o on k.obiteljski_identifikatori_id=o.id 
                                    where o.id=".$brojClanova['id']." group by k.obiteljski_identifikatori_id) as broj_clanova
                                    from korisnici k1 
                                    join obiteljski_identifikatori o on k1.obiteljski_identifikatori_id=o.id
                                    join adrese a on k1.adrese_adresa_id=a.id
                                    left join mjesta m on a.mjesta_id=m.id  
                                    WHERE (k1.uloge_uloga_id != 3 AND k1.bracni_status_flag=0 AND
                                    o.id=".$brojClanova['id'].")");
                    $obitelj=json_decode(json_encode($obitelj),true);
                }
                for($j=0;$j<1;$j++){
                    if(count($obitelj)>0){
                        $roditelji[$i]['prviRoditeljId']=$obitelj[$j]['prvi_roditelj_id'];
                        $roditelji[$i]['prviRoditeljIme']=$obitelj[$j]['prvi_roditelj'];
                        $roditelji[$i]['drugiRoditeljId']=NULL;
                        $roditelji[$i]['drugiRoditeljIme']=NULL;
                        $roditelji[$i]['broj_clanova']=$obitelj[$j]['broj_clanova'];;
                
                    }
                }
                $i++;
            }
        }
        $roditelji=json_decode(json_encode($roditelji),true);
        $data3=$roditelji;

        return view("obitelji.filtriraneObitelji",compact('data3','dodatniFilteriZaObaRoditelja','dodatniFilteriZaJednogRoditelja','filterBrojaClanova'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
