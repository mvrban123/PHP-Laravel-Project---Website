<?php

// put models in a different namespace https://stackoverflow.com/a/44080541
namespace App\Models\Search;
use App\Models\Search\PretragaComboBoxType;
use App\Models\Search\PretragaComboBoxOperation;

class PretragaComboBox extends ElementPretrage{

    public $moguceVrijednosti = array();
    public $odabranaVrijednost;
    public $naziv;
    public $moguceOperacije = array();
    public $odabranaOperacija;
    public $vrijednostPretrazivanja;

    function __construct($type){
        parent::__construct();
        $this->SetupType($type);
    }

    private function SetupType($type){
        switch ($type) {
            case PretragaComboBoxType::KOR_PROFIL:
                $this->naziv = "Polje korisničkog profila";
                //TODO - Dohvatiti iz baze
                $this->DodajMogucuVrijednost("Korisničko ime");
                $this->DodajMogucuVrijednost("E-mail");
                $this->DodajMogucuVrijednost("Ime");
                $this->DodajMogucuVrijednost("Prezime");
                $this->DodajMogucuVrijednost("OIB");
                $this->DodajMogucuVrijednost("Radni interesi");
                $this->DodajMogucuVrijednost("Mjesto stanovanja");
                $this->DodajMogucuVrijednost("Zanimanje");
                $this->DodajMogucuVrijednost("Mobilni telefon");
                $this->DodajMogucuVrijednost("Fiksi telefon");

                //Dodavanje mogućih operacija
                array_push($this->moguceOperacije,
                    PretragaComboBoxOperation::JEDNAKO,
                    PretragaComboBoxOperation::SADRZI,
                    PretragaComboBoxOperation::NE_SADRZI,
                    PretragaComboBoxOperation::POCINJE_S,
                    PretragaComboBoxOperation::ZAVRSAVA_NA,
                    PretragaComboBoxOperation::JE_PRAZANO,
                    PretragaComboBoxOperation::NIJE_PRAZANO
                );
                $this->odabranaVrijednost = "Korisničko ime";
                $this->odabranaOperacija = "jednako";
                $this->vrijednostPretrazivanja = "";
                break;
        }
    }

    function DodajMogucuVrijednost($mogucaVrijednost){
        array_push($this->moguceVrijednosti, $mogucaVrijednost);
        if(count($this->moguceVrijednosti) == 1){
            $this->odabranaVrijednost = $mogucaVrijednost;
        }
    }

    function PostaviOdabranuVrijednost($novaVrijednost){
        $this->odabranaVrijednost = $novaVrijednost;
    }   
    
    function PostaviOdabranuOperaciju($novaOperacija){
        $this->odabranaOperacija = $novaOperacija;
    }    
    
    function PostaviVrijednostPretrazivanja($novaVrijednost){
        $this->vrijednostPretrazivanja = $novaVrijednost;
    }

    function DohvatiOdabranuVrijednost($vrijednost){
        if($vrijednost == "Korisničko ime"){
            return "korisnicko_ime";
        }
        else if($vrijednost == "E-mail"){
            return "email";
        }   
        else if($vrijednost == "Ime"){
            return "ime";
        }   
        else if($vrijednost == "Prezime"){
            return "prezime";
        }   
        else if($vrijednost == "OIB"){
            return "oib";
        }   
        else if($vrijednost == "Radni interesi"){
            return "radni_interesi";
        }
        else if($vrijednost == "Mjesto stanovanja"){
            return "naziv";
        } 
        else if($vrijednost == "Mobilni telefon"){
            return "mobilni_telefon";
        }  
        else if($vrijednost == "Fiksi telefon"){
            return "fiksni_telefon";
        } 
        else if($vrijednost == "Zanimanje"){
            return "zanimanje";
        }
    }

    function DohvatiView(){
        $view = "<div id='".$this->ID."'>";
 
        //Dodavanje atributa u combo box
        $view = $view." <select style='width:25% !important; min-width:75px;' class='cmbVrijednosti' onchange='setTypePretrage(\"".$this->ID."\",\"cmbVrijednosti\")'>";
        foreach($this->moguceVrijednosti as $vrijednost){
            if($vrijednost == $this->odabranaVrijednost){
                $view = $view."<option value='".$vrijednost."' selected>".$vrijednost."</option>";
            }
            else{
                $view = $view."<option value='".$vrijednost."'>".$vrijednost."</option>";
            }
        }
        $view = $view."</select>";

        //Dodavanje operacije u combo box
        $view = $view." <select style='width:25% !important; min-width:75px;' class='cmbOperacije' onchange='setTypePretrage(\"".$this->ID."\",\"cmbOperacije\")'>";
        foreach($this->moguceOperacije as $vrijednost){
            if($vrijednost == $this->odabranaOperacija){
                $view = $view."<option value='".$vrijednost."' selected>".$vrijednost."</option>";
            }
            else{
                $view = $view."<option value='".$vrijednost."'>".$vrijednost."</option>";
            }
        }
        $view = $view."</select>";

        $view = $view. "<input type='text' class='ml-1 valuePretrage' style='width:40% !important; min-width:75px; height:26px;' onchange='setTypePretrage(\"".$this->ID."\",\"ml-1 valuePretrage\")'
                        value = '".$this->vrijednostPretrazivanja."'/>";

        $view = $view."<button id='deleteFilter' class='btn btn-md btn-primary shadow-sm ml-1'
        onClick='deleteButton(\"".$this->ID."\")'><i class='fas fa-trash-alt fa-lg'></i></button>";

        $view = $view."</div>";

        return $view;
    }
}