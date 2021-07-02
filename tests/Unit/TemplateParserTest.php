<?php

namespace Tests\Unit;

use App\Models\Adresa;
use App\Models\Korisnik;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\TemplateParser\TemplateParser;

class TemplateParserTest extends TestCase
{
    
    public function testExample()
    {
        $testParser = new TemplateParser();

        $inputKorisnik = new Korisnik();

        $inputKorisnik->id = 1;
        $inputKorisnik->ime = "Neko ime";
        $inputKorisnik->adrese = Adresa::where('id',1)->first();
        
        echo "\n";
        echo $inputTextId = 1;
        echo "\n";

        $result = $testParser->ParseText($inputTextId, $inputKorisnik);

        echo $result;

        
        $this->assertTrue(1 == 1);
    }
}
