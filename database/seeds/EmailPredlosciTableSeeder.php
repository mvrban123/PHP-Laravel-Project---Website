<?php

use Illuminate\Database\Seeder;
use App\Models\EmailPredlozak;

class EmailPredlosciTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email_predlosci_array = $this->createData();

        foreach($email_predlosci_array as $predlozak) {
            $predlozak->save();
        }
    }

    public function createData()
    {
        $pred_1 = new EmailPredlozak();
        $pred_2 = new EmailPredlozak();

        $pred_1->id = 1;
        $pred_2->id = 2;

        $pred_1->korisnici_id = 10;
        $pred_2->korisnici_id = 10;

        $pred_1->kategorije_predlozaka_id = 1;
        $pred_2->kategorije_predlozaka_id = 2;

        $pred_1->naslov = 'Obavijest o nezavršenoj registraciji';
        $pred_2->naslov = 'Obavijest o neplaćenoj članarini';


        $pred_1->definicija = <<<HTMLDEF
            <b>Pozornost!</b><br>
            <i>Niste dovršili registraciju!</i>
            Vaš O3P.
        HTMLDEF;

        $pred_1->definicija = htmlentities($pred_1->definicija);

        $pred_2->definicija = <<<HTMLDEF
            <b>Pozornost!</b><br>
            <i>Niste platili članarinu za mjesec studeni 2015. godine!</i>
            Vaš O3P.
        HTMLDEF;

        $pred_2->definicija = htmlentities($pred_2->definicija);

        /*
            htmlentities() -> https://www.php.net/manual/en/function.htmlentities.php

            Za dekodiranje koristiti:
            html_entity_decode() -> https://www.php.net/manual/en/function.html-entity-decode.php

        */
        
        $email_predlosci_array = array(
            $pred_1,
            $pred_2
        );

        return $email_predlosci_array;
    }
}