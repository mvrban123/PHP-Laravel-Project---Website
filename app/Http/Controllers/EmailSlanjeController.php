<?php

namespace App\Http\Controllers;

use App\Models\EmailPredlozak;
use App\Models\Korisnik;
use App\Modules\TemplateParser\TemplateParser;
use Illuminate\Http\Request;

class EmailSlanjeController extends Controller
{
    public function index(Request $request)
    {
        
        $sviIdentifikatori = explode("/",$request['rezultat']);

        //kako string počinje / explode uvijek vrati 0. element koji je prazan, zato se miče pomoću unset()
        unset($sviIdentifikatori[0]);

        $dohvaceniKorisnici = [];
        $listaIskoristenihIdentifikatora = [];
        $sviPrimatelji = [[]];

        foreach($sviIdentifikatori as $identifikator){
            $trenutniKorisnik = Korisnik::find($identifikator);
            if($trenutniKorisnik == null){
                continue;
            }
            array_push($dohvaceniKorisnici,$trenutniKorisnik);
        }
        
        $index = 0;
        foreach($dohvaceniKorisnici as $korisnik){
            $obiteljIdentifikator = $korisnik->obiteljski_identifikatori_id;

            if(in_array($obiteljIdentifikator, $listaIskoristenihIdentifikatora) == true){
                continue;
            }

            array_push($listaIskoristenihIdentifikatora, $obiteljIdentifikator);

            foreach($dohvaceniKorisnici as $trenutniKorisnik){
                if($trenutniKorisnik->obiteljski_identifikatori_id == $obiteljIdentifikator){
                    $sviPrimatelji[$index][] = $trenutniKorisnik;
                }
            }
            $index++;
        }

        $sviPredlosci = EmailPredlozak::all();
        //TODO pošalji i sve predloške da se može odabrati
        return view ('email/emailSlanje', compact('sviPrimatelji','sviPredlosci'));
    }

    public function DohvatiPredlozak(Request $request){
        $predlozakId = $request["predlozak"];
        $korisnikId = $request["korisnik"];

        $korisnik = Korisnik::find($korisnikId);

        if($korisnik == null){
            return;
        }

        $parser = new TemplateParser();
        $textRezultat = $parser->ParseText($predlozakId, $korisnik);

        return $textRezultat;

    }
}
