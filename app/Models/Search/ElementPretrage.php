<?php

// put models in a different namespace https://stackoverflow.com/a/44080541
namespace App\Models\Search;


abstract class ElementPretrage{
    public $ID;

    public function __construct(){
        $this->ID = bin2hex(random_bytes(32));
    }
}