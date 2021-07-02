<?php

// put models in a different namespace https://stackoverflow.com/a/44080541
namespace App\Models\Search;

class PretragaComboBoxOperation{
    public const JEDNAKO = "jednako";
    public const SADRZI = "sadrži";
    public const NE_SADRZI = "ne sadrži";
    public const POCINJE_S = "počinje s";
    public const ZAVRSAVA_NA = "završava na";
    public const JE_PRAZANO = "je prazno";
    public const NIJE_PRAZANO = "nije prazno";
    public const JE_MANJE = "manje";
    public const JE_MANJE_JEDNAKO = "manje ili jednako";
    public const JE_VECE = "veće";
    public const JE_VECE_JEDNAKO = "veće ili jednako";

    function DohvatiVrijednostOperacije($vrijednost){
        if($vrijednost == "jednako"){
            return "=";
        }        
        else if($vrijednost == "sadrži" || $vrijednost == "počinje s" || $vrijednost == "završava na"){
            return "like";
        }        
        else if($vrijednost == "ne sadrži"){
            return "not like";
        }               
        else if($vrijednost == "je prazno"){
            return "is null";
        }        
        else if($vrijednost == "nije prazno"){
            return "is not null";
        }        
        else if($vrijednost == "manje"){
            return "<";
        }        
        else if($vrijednost == "manje ili jednako"){
            return "<=";
        }        
        else if($vrijednost == "veće"){
            return ">";
        }  
        else if($vrijednost == "veće ili jednako"){
            return ">=";
        }
    }
} 