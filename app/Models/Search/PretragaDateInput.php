<?php

// put models in a different namespace https://stackoverflow.com/a/44080541
namespace App\Models\Search;
use App\Models\Search\PretragaComboBoxType;
use App\Models\Search\PretragaComboBoxOperation;

class PretragaDateInput extends ElementPretrage{

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
            case 1:
                $this->naziv = "Datum";
                //TODO - Dohvatiti iz baze
                $this->DodajMogucuVrijednost("Datum rođenja");
                $this->DodajMogucuVrijednost("Datum registracije");

                //Dodavanje mogućih operacija
                array_push($this->moguceOperacije,
                    PretragaComboBoxOperation::JEDNAKO,
                    PretragaComboBoxOperation::JE_MANJE,
                    PretragaComboBoxOperation::JE_MANJE_JEDNAKO,
                    PretragaComboBoxOperation::JE_VECE,
                    PretragaComboBoxOperation::JE_VECE_JEDNAKO
                );
                $this->odabranaVrijednost = "Datum rođenja";
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
    
    function DohvatiOdabranuVrijednost($vrijednost){
        if($vrijednost == "Datum rođenja"){
            return "datum_rodenja";
        }
        else if($vrijednost == "Datum registracije"){
            return "datum_vrijeme_registracije";
        }
    }
    
    function PostaviOdabranuOperaciju($novaOperacija){
        $this->odabranaOperacija = $novaOperacija;
    }    
    
    function PostaviVrijednostPretrazivanja($novaVrijednost){
        $this->vrijednostPretrazivanja = $novaVrijednost;
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

        $view = $view. "<input type='date' class='ml-1 valuePretrage' style='width:40% !important; min-width:75px; height:26px;' onchange='setTypePretrage(\"".$this->ID."\",\"ml-1 valuePretrage\")'
                        value = '".$this->vrijednostPretrazivanja."'/>";

        $view = $view."<button id='deleteFilter' class='btn btn-md btn-primary shadow-sm ml-1' 
        onClick='deleteButton(\"".$this->ID."\")'><i class='fas fa-trash-alt fa-lg'></i></button>";

        $view = $view."</div>";

        return $view;
    }
}