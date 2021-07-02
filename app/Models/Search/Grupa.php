<?php

// put models in a different namespace https://stackoverflow.com/a/44080541
namespace App\Models\Search;
use App\Models\Search\LogickaVeza;
use App\Models\Search\ElementPretrage;

class Grupa extends ElementPretrage{
    public $vezaElemenata;
    public $tipVezeElemenata;
    public $elementiPretrage=array();

    function __construct(){
        parent::__construct();
        $this->vezaElemenata = LogickaVeza::AND;
        $this->tipVezeElemenata = "";
        //$elementiPretrage = array();
    }

    public function PromjeniVezuElemenata($noviTipVeze){
        if($noviTipVeze == 1){
            $this->vezaElemenata = LogickaVeza::AND;
        }
        else if($noviTipVeze == 2){
            $this->vezaElemenata = LogickaVeza::OR;
        }
    }    
    public function PromjeniTipVezeElemanata($noviTipVeze){
        $this->tipVezeElemenata = $noviTipVeze;
    }

    public function DodajElementPretrage($noviElementPretrage){
        array_push($this->elementiPretrage, $noviElementPretrage);
    }

    public function UkloniElementPretrage($indexElementaPretrage){
        unset($this->elementiPretrage[$indexElementaPretrage]);
        $this->elementiPretrage = array_values($this->elementiPretrage);
    }

    function DohvatiView(){
        $vezaElemenata = bin2hex(random_bytes(32));
        $tipVezeElemenata = bin2hex(random_bytes(32));
        $view = "<div class='border mt-1 mb-1' id=\"".$this->ID."\">";                                                                                                       
        $view = $view
                    ."<div id=\"".$this->ID."\">"
                    ."Obitelj" 
                    ."<select id=\"".$tipVezeElemenata."\" onchange='promjeniTipVezeElemenata(\"".$tipVezeElemenata."\")'>";
        if($this->tipVezeElemenata == ""){
                $view = $view
                    ."<option value='' selected>mora</option>"
                    ."<option value='!'>ne smije</option>";
        }
        else if($this->tipVezeElemenata == "!"){
                $view = $view
                    ."<option value=''>mora</option>"
                    ."<option value='!' selected>ne smije</option>";
        }
        $view = $view           
                    ."</select>"
                    ."ispunjavati"
                    ."<select id=\"".$vezaElemenata."\" onchange='promjeniVezuElemenata(\"".$vezaElemenata."\")' >";
        if($this->vezaElemenata == "AND"){
            $view = $view
                        ."<option value='1' selected>svaki</option>"
                        ."<option value='2'>bilo koji</option>";
        }
        else if($this->vezaElemenata == "OR"){
                $view = $view
                        ."<option value='1'>svaki</option>"
                        ."<option value='2' selected>bilo koji</option>";
        }
        $view = $view            
                    ."</select>"
                    ."uvjet"
                    ."</div>"; 
        $view = $view
                    ."<div style='display: flex; justify-content: flex-end' id=\"".$this->ID."\"><button class='btn btn-primary mr-1 mt-1 mb-4' id='btnDodajElementPretrage' onClick='deleteButton(\"".$this->ID."\")'>Obriši grupu</button></div>";
        $broj = 0;
        $tag = bin2hex(random_bytes(32));
        foreach($this->elementiPretrage as $element){
            $broj=$broj+1;
            if($broj != 1){
                $view = $view."<div class='ml-3 mt-1 mb-1' id=\"".$this->ID."\">";
                if($this->vezaElemenata == "AND"){
                    $view = $view."i ";
                }
                else{
                    $view = $view."ili ";
                }
                if($this->tipVezeElemenata == "!"){
                    $view = $view."ne smije";
                }
                else{
                    $view = $view."mora";
                }
                $view = $view."</div>";
            }
            $view = $view."<div class='ml-3 mt-1 mb-1' id=\"".$this->ID."\">";
            $view = $view.$element->DohvatiView();
            $view = $view."</div>";
        }
        
        $view = $view."<div style='display: flex; justify-content: flex-end'>";
        $view = $view            
                    ."<p class='mr-2 mt-2 mb-4'>Dodaj element pretrage: </p>";  
        $view = $view
                    ."<select class='mr-2 mt-2 mb-4' id=\"".$tag."\">"
                    ."<option value='1'>Polje korisničkog profila</option>"
                    ."<option value='3'>Datum</option>"
                    ."<option value='4'>Brojevi</option>"
                    ."<option value='2'>Grupa uvjeta</option>"
                    ."</select>";
        $view = $view
                    ."<button class='btn btn-primary mr-1 mt-1 mb-4' id='btnDodajElementPretrage' onClick='loadButton(\"".$this->ID."\",\"".$tag."\")'>Dodaj</button>";     
                    
        $view = $view."</div>";
        $view = $view."</div>";
        return $view;
    }
}