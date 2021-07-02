<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DbControllers\EmailPredlozakController;
use App\Http\Sanitizers\BaseSanitizer;
use App\Models\EmailPredlozak;
use App\Models\EmailPrilog;
use App\Models\EmailPoruka;
use App\Models\KategorijaPredloska;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;

class PredlosciController extends Controller
{
    public function prikaziKreiranjePredloska($predlozakID = 0){
        $sveKategorije = KategorijaPredloska::all();
        $prilog = null;
        $predlozak = null;
        if($predlozakID == 0){
            return view('predlosci/kreirajPredlozak',compact('sveKategorije','prilog','predlozak'));
        }
        else{
            $predlozak = EmailPredlozak::find($predlozakID);
            $prilog = \DB::select('select ep.* from email_prilozi ep join prilozi_predlozaka pp on ep.id=pp.email_prilozi_id where pp.email_predlosci_id = ? && ep.deleted_at is null', [$predlozakID]);
            $prilog = json_decode(json_encode($prilog),true);

            return view('predlosci/kreirajPredlozak',compact('sveKategorije','prilog','predlozak'));
        }

    }

    public function kreirajPredlozak(Request $request){
        
        $input = BaseSanitizer::sanitize($request->all());
        
        if($input['idPredloska']>0){
            $predlozak = EmailPredlozak::find($input['idPredloska']);
            $predlozak->naslov = $input['nazivPredloska'];
            $predlozak->definicija = htmlentities($request['unosPredloska']);
            //TODO razmisli dal je dobro ovako dohvaćat id korisnika
            $predlozak->korisnici_id = 1;//$request->session()->get('korisnik');
            $predlozak->kategorije_predlozaka_id = $input['odabirKategorije'];
            $predlozak->save();

            return $this->prikaziKreiranjePredloska($predlozak->id);
        }
        else{
            $noviPredlozak = new EmailPredlozak();
            $noviPredlozak->naslov = $input['nazivPredloska'];
            $noviPredlozak->definicija = htmlentities($request['unosPredloska']);
            //TODO razmisli dal je dobro ovako dohvaćat id korisnika
            $noviPredlozak->korisnici_id = 1;//$request->session()->get('korisnik');
            $noviPredlozak->kategorije_predlozaka_id = $input['odabirKategorije'];
            $noviPredlozak->save();

            $redPriloga = array();
            if ($request->hasfile('filenames')) {
                foreach ($request->file('filenames') as $file) {
                    $noviPrilog =new EmailPrilog();
                    $noviPrilog->naslov = $file->getClientOriginalName();
                    //$file->move(public_path() . '/mytestfile/', $name);
                    $noviPrilog->putanja = "C:/xampp/htdocs/o3p-crm/storage/app/".$file->store('uploads');
                    $noviPrilog->save();
                    array_push($redPriloga, $noviPrilog->id);
                }
            }

            foreach($redPriloga as $prilog){
                \DB::insert('insert into prilozi_predlozaka (email_prilozi_id, email_predlosci_id) values (?, ?)', [$prilog,$noviPredlozak->id]);
            }

            return $this->prikaziSvePredloske();
        }
    }

    public function DodajPrilogePostojecemPredlosku(Request $request){
        $input = BaseSanitizer::sanitize($request->all());
        $redPriloga = array();
        if ($request->hasfile('filenames')) {
            foreach ($request->file('filenames') as $file) {
                $noviPrilog =new EmailPrilog();
                $noviPrilog->naslov = $file->getClientOriginalName();
                    //$file->move(public_path() . '/mytestfile/', $name);
                $noviPrilog->putanja = "C:/xampp/htdocs/o3p-crm/storage/app/".$file->store('uploads');
                $noviPrilog->save();
                array_push($redPriloga, $noviPrilog->id);
            }
        }   

        foreach($redPriloga as $prilog){
            \DB::insert('insert into prilozi_predlozaka (email_prilozi_id, email_predlosci_id) values (?, ?)', [ $prilog, $input['idPredloska']]);
        }
        

        return $this->prikaziKreiranjePredloska($input['idPredloska']);
    }

    public function prikaziSvePredloske(){

        //$sviPredlosci = EmailPredlozak::get();
        $sviPredlosci = DB::select('SELECT ep.*,kp.naziv,k.ime,k.prezime from email_predlosci ep join kategorije_predlozaka kp on ep.kategorije_predlozaka_id=kp.id JOIN korisnici k on ep.korisnici_id=k.id');
        $sviPredlosci = json_decode(json_encode($sviPredlosci),true);
        return view('predlosci/sviPredlosci', compact('sviPredlosci'));
    }

    public function prikaziPregledPredloska($odabraniPredlozak){
        $predlozak = EmailPredlozak::find($odabraniPredlozak);
        $sviPredlosci = EmailPredlozak::all();
        $prilog = EmailPrilog::find($predlozak['email_prilozi_id']);
        return view('predlosci/pregledPredlosaka', compact('predlozak','sviPredlosci','prilog'));
    }

    public function brisiPredlozak($predlozakZaBrisanje){

        $sviPredlosci = EmailPredlozak::get();

        $predlozakBrisi = EmailPredlozak::find($predlozakZaBrisanje);

        if ($predlozakBrisi['email_prilozi_id'] != null){
            $prilogBrisi = EmailPrilog::find($predlozakBrisi['email_prilozi_id']);
            $koristeniPredlozak = EmailPredlozak::select()->where('email_prilozi_id','=',$prilogBrisi['id']);
            $prilogKoristen = 0;
            foreach($koristeniPredlozak as $predlozak){
                $poslaniMailovi = EmailPoruka::select()->where('email_predlosci_id','=',$predlozak['id'])->get();
                if(count($poslaniMailovi)>0){
                    $prilogKoristen++;
                }
            }
            if($prilogKoristen==0){
                $prilogBrisi->delete();
            }
            
        } 

        if($predlozakBrisi != null){
            $predlozakBrisi->delete();
        }
        $sviPredlosci = EmailPredlozak::get();
        return view('predlosci/sviPredlosci', compact('sviPredlosci'));
    }

    public function brisiPrilog($odabraniPredlozak, $prilogZaBrisanje){
        $prilogBrisi = EmailPrilog::find($prilogZaBrisanje);
        /*$koristeniPredlozak = EmailPredlozak::select()->where('email_prilozi_id','=',$prilogBrisi['id'])->get();
        $prilogKoristen = 0;
        foreach($koristeniPredlozak as $predlozak){
            $poslaniMailovi = EmailPoruka::select()->where('email_predlosci_id','=',$predlozak['id'])->get();
            if(count($poslaniMailovi)>0){
                $prilogKoristen++;
            }
        }*/
        //if($prilogKoristen==0){
        $prilogBrisi->delete();
        //}
        return $this->prikaziKreiranjePredloska($odabraniPredlozak);
    }

    public function upload(Request $request)
    {
        if ($request->hasfile('filenames')) {
            foreach ($request->file('filenames') as $file) {
                $name = $file->getClientOriginalName();
                $file->move(public_path() . 'C:/xampp/htdocs/o3p-crm/storage/app/', $name);
                $data[] = $name;
            }
            return back()->with('Success!','Data Added!');
        }
    }

    public function DowloadFile($predlozak, $prilog){
        $dl = EmailPrilog::find($prilog);

        return response()->download($dl->putanja);
    }
}
