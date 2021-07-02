<?php 

//vendor/bin/phpunit --filter TemplateParserTest


namespace App\Modules\TemplateParser;

use Illuminate\Support\Str;
use ReflectionClass;
Use App\Models\Adresa;
use App\Models\EmailPredlozak;
use App\Models\Korisnik;

class TemplateParser{

    /*
     Prilikom mjenjanja prefiksa, postfiksa i znaka za odvajanje treba promijeniti varijable $prefix, $postfix i $znakZaOdvajanje samo prije 
     definicije funkcije, ostatak je automatski. Treba paziti na to da varijabla $prefix započinje, i $postifx završavaju znakom definiranim
     u varijabli $prefixStart (odnosi se na obje varijable, neovisno o imenu).
    */
    public $prefixStart = "#";

    public $prefix = "#!!";
    
    public $postfix = "!!#";

    public $znakZaOdvajanje = ".";

    public $brojacZaPunjenje = -1;

    public $poljeIzKojegSePuni = [];


    public function ParseText($inputPredlozakId, $zadaniKorisnik){
        $pronadeniPredlozak = EmailPredlozak::find($inputPredlozakId);
        $inputPredlozak = $pronadeniPredlozak->definicija;
        $regExp = $this->prefix."(\w+.)*".$this->postfix;

        preg_match_all($regExp, $inputPredlozak, $resultArray, PREG_OFFSET_CAPTURE);

        #echo $resultArray[0][0][0];
        
        #TODO PROUČI TREBAM LI OBA FOREACHA
        foreach ($resultArray[0] as $result){
            
            $trim = $this->trimText($result[0]);
          

            $rezultatiOdvajanja = explode($this->znakZaOdvajanje, $trim);
            
            
            foreach($rezultatiOdvajanja as $key => $rezultatOdvajanja){
                if($key == 0){
                    $dohvatPodatka = $zadaniKorisnik;
                    continue;
                }

                $dohvatPodatka = $dohvatPodatka->$rezultatOdvajanja;
                
            }

            array_push($this->poljeIzKojegSePuni, $dohvatPodatka);

        }

        

        $rezultat = preg_replace_callback($regExp, function ($matches){

            $this->brojacZaPunjenje += 1;
            $this->poljeIzKojegSePuni[$this->brojacZaPunjenje];
            return $this->poljeIzKojegSePuni[$this->brojacZaPunjenje];
            
        }, $inputPredlozak);


        #reset globalnih varijabli
        $brojacZaPunjenje = -1;
        $poljeIzKojegSePuni = NULL;

        return $rezultat;
    }

    

    /*
    Funkcija prvo miče delimiter iz prefixa i postfixa, te nakon toga miče prefix i postfix 
    iz texta zapisanog u $textToTrim parametru.
    */
    public function trimText($textToTrim){
        $prefixTrim = str_replace($this->prefixStart,"",$this->prefix);
        $postfixTrim = str_replace($this->prefixStart,"",$this->postfix);

        $trimmedTextPrefix = str_replace($prefixTrim,"",$textToTrim);

        $trimmedText = str_replace($postfixTrim,"",$trimmedTextPrefix);

        return $trimmedText;
    }
    

}


?>