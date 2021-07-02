<?php

// put models in a different namespace https://stackoverflow.com/a/44080541
namespace App\Http\Controllers;

use App\Models\Search\Grupa;
use App\Models\Search\PretragaComboBox;
use App\Models\Search\PretragaComboBoxType;
use App\Models\Search\PretragaDateInput;
use App\Models\Search\PretragaNumberInput;
use App\Models\Search\PretragaComboBoxOperation;
use Illuminate\Http\Request;
use App\Http\Sanitizers\BaseSanitizer;
use Illuminate\Database\Eloquent\Model\Korisnik;


/* TODO
 - *Ukloniti gumb 'Dodaj grupu uvjeta' (Obavljeno)
 - *Dodati gumb za brisanje unutarnje grupe 
   (problem: ne brisati zadnju grupu ili ako je obrisana zadnja, onda prikazati gumb dodaj grupu) (Obavljeno)
 - *Riješiti problem sa brisanjem elemenata unutarnjih grupa (Obavljeno)
 - *Riješiti problem sa dodavanje novih grupa u grupu u kojoj je već jedna podgrupa (Obavljeno)
 - *Omogućiti izmjenu Mora/Ne smije i Svaki/bilo koji u grupi (Obavljeno)

 - *Dodati osim comboboxa, datum i broj nečega (Obavljeno)
 - *Izgraditi upit do kraja (Obavljeno)
 - *Prikazati rezultat (Obavljeno)

 - Dodati mjesto/adresu
 - Dodati broj djece
 - 
*/


class PretragaController{
    public $pretraga = NULL;

    public function InicijalizacijaPretrage(){
        if(session_status()==PHP_SESSION_NONE){
            session_start();
        }
        if(isset($_SESSION['pretraga'])){
            $this->pretraga = unserialize($_SESSION['pretraga']);
            //var_dump($this->pretraga);
        }

        if(is_null($this->pretraga)){
            $this->pretraga = new Grupa();
        }
    }

    public function DohvatiViewPretrage(Request $request){
        $this->InicijalizacijaPretrage();

        $_SESSION['pretraga'] = serialize($this->pretraga);

        return $this->pretraga->DohvatiView();
    }

    public function DodajElementPretrage(Request $request){
        $attributes = BaseSanitizer::sanitize($request->all());
        $elementPregrage = $attributes['elementPretrage'];
        $idGrupe = $attributes['idGrupe'];

        $this->InicijalizacijaPretrage();
        $element = $this->SearchElement($this->pretraga, $idGrupe);

        switch ($elementPregrage) {
            case '1':
                $element->DodajElementPretrage(new PretragaComboBox(PretragaComboBoxType::KOR_PROFIL));
                break;
            case '2':
                $element->DodajElementPretrage(new Grupa());
                break; 
            case '3':
                $element->DodajElementPretrage(new PretragaDateInput(1));
                break;
            case '4':
                $element->DodajElementPretrage(new PretragaNumberInput(1));
                break;
        }
        $_SESSION['pretraga'] = serialize($this->pretraga);
        return $this->pretraga->DohvatiView();
    }

    public function SearchElement($elementPretrage, $element_id)
    {
        if ($elementPretrage->ID == $element_id)
            return $elementPretrage;

        foreach($elementPretrage->elementiPretrage as $elementPretrage){
            if ($elementPretrage->ID == $element_id)
                return $elementPretrage;

            if ($elementPretrage instanceof Grupa)
            {
                $result = $this->SearchElement($elementPretrage, $element_id);
                if ($result != "")
                    return $result;
            }
        }
        return "";
    }

    public function UkloniElementPretrage(Request $request){
        $this->InicijalizacijaPretrage();

        $idElementa = BaseSanitizer::sanitize($request->all());
        $indexElementa = 0;   

        $element = $this->SearchElement($this->pretraga, $idElementa['grupaPretrage']);
        foreach($element->elementiPretrage as $elementPretrage){
            if($elementPretrage->ID == $idElementa['idPretraga']){
                $element->UkloniElementPretrage($indexElementa);
                break;
            }
            $indexElementa++;
        }

        $_SESSION['pretraga'] = serialize($this->pretraga);
        return $this->pretraga->DohvatiView();
    }

    public function ObrisiFilterPretrage(){
        if(session_status()==PHP_SESSION_NONE){
            session_start();
        }
        if(isset($_SESSION['pretraga'])){
            unset($_SESSION['pretraga']);
        }

        return null;
    }

    public function PromjeniTipVeze(Request $request){
        $this->InicijalizacijaPretrage();

        $attributes = BaseSanitizer::sanitize($request->all());

        $element = $this->SearchElement($this->pretraga, $attributes['elementPretrage']);
        $element->PromjeniVezuElemenata($attributes['vrijednost']);

        $_SESSION['pretraga'] = serialize($this->pretraga);
        return $this->pretraga->DohvatiView();
    }   
    
    public function PromjeniTipVezeElementa(Request $request){
        $this->InicijalizacijaPretrage();

        $attributes = BaseSanitizer::sanitize($request->all());

        $element = $this->SearchElement($this->pretraga, $attributes['elementPretrage']);
        $element->PromjeniTipVezeElemanata($attributes['vrijednost']);

        $_SESSION['pretraga'] = serialize($this->pretraga);
        return $this->pretraga->DohvatiView();
    }

    public function ComboBoxSetValue(Request $request){
        $this->InicijalizacijaPretrage();

        $attributes = BaseSanitizer::sanitize($request->all());

        $idElementa = $attributes['idPretraga'];
        $idComboBox = $attributes['idComboBoxa'];
        $value = $attributes['value'];

        $element = $this->SearchElement($this->pretraga, $attributes['idPretraga']);
        if($idComboBox == "cmbVrijednosti"){
            $element->PostaviOdabranuVrijednost($value);
        }
        else if($idComboBox == "cmbOperacije"){
            $element->PostaviOdabranuOperaciju($value);
        }
        else if($idComboBox == "ml-1 valuePretrage"){
            $element->PostaviVrijednostPretrazivanja($value);
        }

        $_SESSION['pretraga'] = serialize($this->pretraga);      
    }

    public function PretraziObitelji()
    {
        $this->InicijalizacijaPretrage();
        $querryZaObaRoditelj = "";
        $querryZaJednogRoditelj = "";
        $querryZaBrojClanovaObitelji = "";

        $vezaElemenata = $this->pretraga->vezaElemenata; 
        $querryZaObaRoditelj = $querryZaObaRoditelj."(";
        $querryZaObaRoditelj = $this->IzgradiQueryZaObaRoditelja($querryZaObaRoditelj, $this->pretraga, 0, $vezaElemenata);
        $querryZaObaRoditelj = $querryZaObaRoditelj.")";

        $vezaElemenata = $this->pretraga->vezaElemenata; 
        $querryZaJednogRoditelj = $querryZaJednogRoditelj."(";
        $querryZaJednogRoditelj = $this->IzgradiQueryZaJednogRoditelja($querryZaJednogRoditelj, $this->pretraga, 0, $vezaElemenata);
        $querryZaJednogRoditelj = $querryZaJednogRoditelj.")";

        $querryZaBrojClanovaObitelji = $this->IzgradiQueryZaBrojČlanova($querryZaBrojClanovaObitelji, $this->pretraga);

        $brojClanovaPoObitelji=\DB::select('select o.id,count(k.id) as clanovi 
        from korisnici k join obiteljski_identifikatori o on k.obiteljski_identifikatori_id=o.id 
        where k.uloge_uloga_id!=3 group by 1');
        $brojClanovaPoObitelji=json_decode(json_encode($brojClanovaPoObitelji),true);
        $i = 0;
        $roditelji = array();
        foreach($brojClanovaPoObitelji as $brojClanova){
            if($brojClanova['clanovi']>1){
                if(strlen($querryZaObaRoditelj)>3){
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
                                            " AND ".$querryZaObaRoditelj." ".$querryZaBrojClanovaObitelji." order by k1.id");                   
                                           
                }
                else{
                    $obitelj = \DB::select("SELECT distinct o.id,k1.id as prvi_roditelj_id,concat(k1.ime,' ',k1.prezime) as prvi_roditelj,
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
                                            AND o.id=".$brojClanova['id']." AND k1.id!=k2.id AND k2.id!=k1.id) ".$querryZaBrojClanovaObitelji." order by k1.id");
                }
                $obitelj=json_decode(json_encode($obitelj),true);

                if(count($obitelj)>0){
                    $roditelji[$i]['prviRoditeljId']=$obitelj[0]['prvi_roditelj_id'];
                    $roditelji[$i]['prviRoditeljIme']=$obitelj[0]['prvi_roditelj'];
                    $roditelji[$i]['drugiRoditeljId']=$obitelj[0]['drugi_roditelj_id'];
                    $roditelji[$i]['drugiRoditeljIme']=$obitelj[0]['drugi_roditelj'];
                    $i++;
                }
            }
            else{
                if(strlen($querryZaJednogRoditelj)>3){
                    $obitelj=\DB::select("SELECT distinct o.id,k1.id as prvi_roditelj_id,concat(k1.ime,' ',k1.prezime) as prvi_roditelj,
                                    (select count(k.id) as clanovi from korisnici k 
                                    join obiteljski_identifikatori o on k.obiteljski_identifikatori_id=o.id 
                                    where o.id=".$brojClanova['id']." group by k.obiteljski_identifikatori_id) as broj_clanova
                                    from korisnici k1 
                                    join obiteljski_identifikatori o on k1.obiteljski_identifikatori_id=o.id
                                    join adrese a on k1.adrese_adresa_id=a.id
                                    left join mjesta m on a.mjesta_id=m.id  
                                    WHERE (k1.uloge_uloga_id != 3 AND k1.bracni_status_flag=0 AND
                                    o.id=".$brojClanova['id'].") AND ".$querryZaJednogRoditelj." ".$querryZaBrojClanovaObitelji);
                }
                else{
                    $obitelj=\DB::select("SELECT distinct o.id,k1.id as prvi_roditelj_id,concat(k1.ime,' ',k1.prezime) as prvi_roditelj,
                                        (select count(k.id) as clanovi from korisnici k 
                                        join obiteljski_identifikatori o on k.obiteljski_identifikatori_id=o.id 
                                        where o.id=".$brojClanova['id']." group by k.obiteljski_identifikatori_id) as broj_clanova
                                        from korisnici k1 
                                        join obiteljski_identifikatori o on k1.obiteljski_identifikatori_id=o.id
                                        join adrese a on k1.adrese_adresa_id=a.id
                                        left join mjesta m on a.mjesta_id=m.id
                                        WHERE (k1.uloge_uloga_id != 3 AND k1.bracni_status_flag=0 AND
                                        o.id=".$brojClanova['id'].") ".$querryZaBrojClanovaObitelji);
                }
                $obitelj=json_decode(json_encode($obitelj),true);

                if(count($obitelj)>0){
                    $roditelji[$i]['prviRoditeljId'] = $obitelj[0]['prvi_roditelj_id'];
                    $roditelji[$i]['prviRoditeljIme'] = $obitelj[0]['prvi_roditelj'];
                    $roditelji[$i]['drugiRoditeljId'] = NULL;
                    $roditelji[$i]['drugiRoditeljIme'] = NULL;
                    $i++;
                }
            }
        }

        $roditelji=json_decode(json_encode($roditelji),true);
        $data3=$roditelji;

        return view("obitelji.filtriraneObitelji",compact('data3','querryZaBrojClanovaObitelji','querryZaObaRoditelj','querryZaJednogRoditelj'));
    }

    public function IzgradiQueryZaObaRoditelja($querry, $elementPretrage, $razina, $vezaElemenata)
    {
        $operation = new PretragaComboBoxOperation;
        foreach($elementPretrage->elementiPretrage as $elementPretrage){
            if ($razina > 0)
                    $querry = $querry." ". $vezaElemenata." ";

            if ($elementPretrage instanceof Grupa)
            {
                $vezaElemenata = $elementPretrage->vezaElemenata; 
                $razina = 0;       
                $querry = $querry."(";
                $querry = $this->IzgradiQueryZaObaRoditelja($querry, $elementPretrage, $razina, $vezaElemenata);
                $querry = $querry.")";
            }

            if ($elementPretrage instanceof PretragaComboBox || $elementPretrage instanceof PretragaDateInput || $elementPretrage instanceof PretragaNumberInput)
            {
                if($elementPretrage->odabranaVrijednost == "Broj članova"){
                    $razina = -1; 
                }
                else if($elementPretrage->odabranaOperacija == "je prazno" || $elementPretrage->odabranaOperacija == "nije prazno"){
                    if($elementPretrage->odabranaVrijednost == "Mjesto stanovanja"){
                        $querry = $querry
                            ."(m1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." OR "                            
                            ."m2.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija).")";
                    }
                    else{
                        $querry = $querry
                            ."(k1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." OR "                            
                            ."k2.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija).")";
                    }
                }
                else if($elementPretrage->odabranaOperacija == "sadrži" || $elementPretrage->odabranaOperacija == "ne sadrži"){
                    if($elementPretrage->odabranaVrijednost == "Mjesto stanovanja"){
                        $querry = $querry
                            ."(m1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '%"
                            .$elementPretrage->vrijednostPretrazivanja."%' OR "                            
                            ."m2.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '%"
                            .$elementPretrage->vrijednostPretrazivanja."%')";
                    }
                    else{
                        $querry = $querry
                            ."(k1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '%"
                            .$elementPretrage->vrijednostPretrazivanja."%' OR "                            
                            ."k2.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '%"
                            .$elementPretrage->vrijednostPretrazivanja."%')";
                    }
                }
                else if($elementPretrage->odabranaOperacija == "počinje s"){
                    if($elementPretrage->odabranaVrijednost == "Mjesto stanovanja"){
                        $querry = $querry
                            ."(k1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '"
                            .$elementPretrage->vrijednostPretrazivanja."%' OR "                            
                            ."k2.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '"
                            .$elementPretrage->vrijednostPretrazivanja."%')";
                    }
                    else{
                        $querry = $querry
                            ."(k1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '"
                            .$elementPretrage->vrijednostPretrazivanja."%' OR "                            
                            ."k2.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '"
                            .$elementPretrage->vrijednostPretrazivanja."%')";
                    }
                }
                else if($elementPretrage->odabranaOperacija == "završava na"){
                    if($elementPretrage->odabranaVrijednost == "Mjesto stanovanja"){
                        $querry = $querry
                            ."(m1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '%"
                            .$elementPretrage->vrijednostPretrazivanja."' OR "                            
                            ."m2.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '%"
                            .$elementPretrage->vrijednostPretrazivanja."')";
                    }
                    else{
                        $querry = $querry
                            ."(k1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '%"
                            .$elementPretrage->vrijednostPretrazivanja."' OR "                            
                            ."k2.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '%"
                            .$elementPretrage->vrijednostPretrazivanja."')";
                    }
                }
                else{
                    if($elementPretrage->odabranaVrijednost == "Mjesto stanovanja"){
                        $querry = $querry
                            ."(m1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '"
                            .$elementPretrage->vrijednostPretrazivanja."' OR "                            
                            ."m2.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '"
                            .$elementPretrage->vrijednostPretrazivanja."')";
                    }
                    else{
                        $querry = $querry
                            ."(k1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '"
                            .$elementPretrage->vrijednostPretrazivanja."' OR "                            
                            ."k2.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '"
                            .$elementPretrage->vrijednostPretrazivanja."')";
                    }
                }
            }
            $razina = $razina + 1;
        }

        return $querry;
    }

    public function IzgradiQueryZaJednogRoditelja($querry, $elementPretrage, $razina, $vezaElemenata)
    {
        $operation = new PretragaComboBoxOperation;
        foreach($elementPretrage->elementiPretrage as $elementPretrage){
            if ($razina > 0 && !($elementPretrage instanceof PretragaNumberInput))
                    $querry = $querry." ". $vezaElemenata." ";

            if ($elementPretrage instanceof Grupa)
            {
                $vezaElemenata = $elementPretrage->vezaElemenata; 
                $razina = 0;       
                $querry = $querry."(";
                $querry = $this->IzgradiQueryZaJednogRoditelja($querry, $elementPretrage, $razina, $vezaElemenata);
                $querry = $querry.")";
            }

            if ($elementPretrage instanceof PretragaComboBox || $elementPretrage instanceof PretragaDateInput || $elementPretrage instanceof PretragaNumberInput)
            {
                if($elementPretrage->odabranaVrijednost == "Broj članova"){
                    $razina = -1; 
                }
                else if($elementPretrage->odabranaOperacija == "je prazno" || $elementPretrage->odabranaOperacija == "nije prazno"){
                    if($elementPretrage->odabranaVrijednost == "Mjesto stanovanja"){
                        $querry = $querry
                            ."(m.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija).")";
                    }
                    else{
                        $querry = $querry
                            ."(k1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija).")";
                    }       
                }
                else if($elementPretrage->odabranaOperacija == "sadrži" || $elementPretrage->odabranaOperacija == "ne sadrži"){
                    if($elementPretrage->odabranaVrijednost == "Mjesto stanovanja"){
                        $querry = $querry
                            ."(m.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '%"
                            .$elementPretrage->vrijednostPretrazivanja."%')";
                    } 
                    else{
                        $querry = $querry
                            ."(k1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '%"
                            .$elementPretrage->vrijednostPretrazivanja."%')";
                    }
                }
                else if($elementPretrage->odabranaOperacija == "počinje s"){
                    if($elementPretrage->odabranaVrijednost == "Mjesto stanovanja"){
                        $querry = $querry
                            ."(m.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '"
                            .$elementPretrage->vrijednostPretrazivanja."%')";
                    }
                    else{
                        $querry = $querry
                            ."(k1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '"
                            .$elementPretrage->vrijednostPretrazivanja."%')";
                    }
                }
                else if($elementPretrage->odabranaOperacija == "završava na"){
                    if($elementPretrage->odabranaVrijednost == "Mjesto stanovanja"){
                        $querry = $querry
                            ."(m.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '%"
                            .$elementPretrage->vrijednostPretrazivanja."')";
                    }
                    else{
                        $querry = $querry
                            ."(k1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '%"
                            .$elementPretrage->vrijednostPretrazivanja."')";
                    }
                }
                else{
                    if($elementPretrage->odabranaVrijednost == "Mjesto stanovanja"){
                        $querry = $querry
                            ."(m.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '"
                            .$elementPretrage->vrijednostPretrazivanja."')";
                    }
                    else{
                        $querry = $querry
                            ."(k1.".$elementPretrage->DohvatiOdabranuVrijednost($elementPretrage->odabranaVrijednost)." "
                            .$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." '"
                            .$elementPretrage->vrijednostPretrazivanja."')";
                    }
                }
            }
            $razina = $razina + 1;
        }

        return $querry;
    }

    public function IzgradiQueryZaBrojČlanova($querry, $elementPretrage)
    {
        $operation = new PretragaComboBoxOperation;
        foreach($elementPretrage->elementiPretrage as $elementPretrage){
            if ($elementPretrage instanceof Grupa)
            {
                $querry = $this->IzgradiQueryZaObaRoditelja($querry, $elementPretrage, $razina, $vezaElemenata);
            }

            if ($elementPretrage instanceof PretragaNumberInput)
            {
                if($elementPretrage->odabranaVrijednost == "Broj članova"){
                    $querry = " having broj_clanova ".$operation->DohvatiVrijednostOperacije($elementPretrage->odabranaOperacija)." ".$elementPretrage->vrijednostPretrazivanja;
                }
            }
        }
        return $querry;
    }
}