<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DbControllers\EmailPredlozakController;
use App\Http\Sanitizers\BaseSanitizer;
use App\Models\EmailPredlozak;
use App\Models\KategorijaPredloska;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(){

        $autoPoruke=\DB::select("SELECT a.*, m.naslov, concat(k.ime,' ',k.prezime) as kreator 
                                 from auto_poruke_postavke a 
                                 join email_predlosci m on a.email_predlosci_id=m.id 
                                 join korisnici k on m.korisnici_id=k.id"); 
            
        $autoPoruke=json_decode(json_encode($autoPoruke), true);
        $sviPredlosci=EmailPredlozak::all(); 
        $brojRedova=count($autoPoruke);
        
        $odgodeSlanja=\DB::select("SELECT * 
                                 from tipovi_odgode");
        
        $odgodeSlanja=json_decode(json_encode($odgodeSlanja), true);

        return view('email/postavke', compact('autoPoruke', 'sviPredlosci','brojRedova','odgodeSlanja'));

    }
    public function updatePredlosci(Request $request){
        
        $input = BaseSanitizer::sanitize($request->all());
        foreach($input as $predlozak){
            
            $query=\DB::update('update auto_poruke_postavke set omoguceno = '.$predlozak['autoSlanje'].', 
                                email_predlosci_id= '.$predlozak['predlozak'].', tipovi_odgode_id='.$predlozak['odgoda'].' 
                                where  id = '. $predlozak['poruka_id']);
        }
        return 1;
        
    }

    public function autoEmails($id){
        $mail=$id;
        $mailovi=\DB::select("SELECT e.id, e.datum_vrijeme_poslano, e.predmet,concat(k1.ime,' ',k1.prezime) AS posiljatelj,
                            concat(k2.ime,' ',k2.prezime) AS primatelj 
                            FROM email_poruke e 
                            JOIN korisnici k1 ON e.from_korisnici_id=k1.id
                            JOIN korisnici k2 ON e.to_korisnici_id=k2.id where e.auto_poruke_postavke_id= ".$id);
        $mailovi=json_decode(json_encode($mailovi), true);
        $brojRedova=count($mailovi);
        return view('email/pregled', compact('mailovi','mail','brojRedova'));
    }

    public function filterAutoEmails($id){
        $od=$_POST["od"];
        $do=$_POST["do"];
        $mail=$id;
        $mailovi=\DB::select("SELECT e.id, e.datum_vrijeme_poslano, e.predmet,concat(k1.ime,' ',k1.prezime) AS posiljatelj,
                            concat(k2.ime,' ',k2.prezime) AS primatelj 
                            FROM email_poruke e 
                            JOIN korisnici k1 ON e.from_korisnici_id=k1.id
                            JOIN korisnici k2 ON e.to_korisnici_id=k2.id where e.auto_poruke_postavke_id= ".$id." AND (e.datum_vrijeme_poslano BETWEEN '".$od."' AND '".$do."')" );
        $mailovi=json_decode(json_encode($mailovi), true);
        $brojRedova=count($mailovi);
        return view('email/pregled', compact('mailovi','mail','brojRedova'));
    }

    public function prikazTijelaPoruke(Request $request){
        $id = BaseSanitizer::sanitize($request->all());
        $poruke=\DB::select("SELECT  e.id, e.datum_vrijeme_poslano, e.tijelo, e.predmet,concat(k1.ime,' ',k1.prezime) AS posiljatelj,
                            concat(k2.ime,' ',k2.prezime) AS primatelj 
                            FROM email_poruke e 
                            JOIN korisnici k1 ON e.from_korisnici_id=k1.id
                            JOIN korisnici k2 ON e.to_korisnici_id=k2.id 
                            WHERE e.id= ".$id[0]);
        $poruke=json_decode(json_encode($poruke), true);
        $mailovi=array();
        foreach ($poruke as $poruka){
            $mailovi[0]['id'] = $poruka['id'];
            $mailovi[0]['datum_vrijeme_poslano'] = $poruka['datum_vrijeme_poslano'];
            $mailovi[0]['predmet'] = $poruka['predmet'];
            $mailovi[0]['posiljatelj'] = $poruka['posiljatelj'];
            $mailovi[0]['primatelj'] = $poruka['primatelj'];
            if(strlen($poruka['tijelo'])>500){
                $mailovi[0]['tijelo'] = substr($poruka['tijelo'],0,500)."...";
            }
            else{
                $mailovi[0]['tijelo'] = $poruka['tijelo'];
            }
        }
        return view('email/prikaz', compact('mailovi'));
    }
}