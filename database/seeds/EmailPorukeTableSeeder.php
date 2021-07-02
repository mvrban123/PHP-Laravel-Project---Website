<?php

use Illuminate\Database\Seeder;
use App\Models\EmailPredlozak;
use App\Models\EmailPoruka;

class EmailPorukeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email_msg_array = $this->createData();

        foreach($email_msg_array as $email_msg) {
            $email_msg->save();
        }
    }

    private function createData()
    {
        $email_msg_1 = new EmailPoruka();
        $email_msg_2 = new EmailPoruka();
        $email_msg_3 = new EmailPoruka();

        $pred_1 = EmailPredlozak::where('id', 1)->first();
        $pred_2 = EmailPredlozak::where('id', 2)->first();
        
        $email_msg_1->id = 1;
        $email_msg_2->id = 2;
        $email_msg_3->id = 3;

        $email_msg_1->predmet = 'Obitelji 3 Plus - Obavijest o registraciji';
        $email_msg_2->predmet = 'Obitelji 3 Plus - Obavijest o registraciji';
        $email_msg_3->predmet = 'Obitelji 3 Plus - Obavijest o neplaćenoj članarini';

        $email_msg_1->email_predlosci_id = 1;
        $email_msg_2->email_predlosci_id = 1;
        $email_msg_3->email_predlosci_id = 2;

        $email_msg_1->auto_poruke_postavke_id = 1;
        $email_msg_2->auto_poruke_postavke_id = 1;
        $email_msg_3->auto_poruke_postavke_id = 2;

        $email_msg_1->tijelo = $pred_1->definicija;
        $email_msg_2->tijelo = $pred_1->definicija;
        $email_msg_3->tijelo = $pred_2->definicija;
        
        $email_msg_1->from_korisnici_id = 10; // Administrator Miljenko Draganić
        $email_msg_2->from_korisnici_id = 10;
        $email_msg_3->from_korisnici_id = 10;

        $email_msg_1->to_korisnici_id = 1; // Spomenka Frankopan
        $email_msg_2->to_korisnici_id = 2; // Fran Frankopan
        $email_msg_3->to_korisnici_id = 6; // Željko Zaplatić
        $email_msg_3->cc_korisnici_id = 10; // Administrator Miljenko Draganić
        $email_msg_3->bcc_korisnici_id = 10; // Administrator Miljenko Draganić

        $email_msg_1->datum_vrijeme_poslano = date('Y-m-d H:i:s');
        $email_msg_2->datum_vrijeme_poslano = date('Y-m-d H:i:s');
        $email_msg_3->datum_vrijeme_poslano = date('Y-m-d H:i:s');

        $email_msg_array = array(
            $email_msg_1,
            $email_msg_2,
            $email_msg_3
        );

        return $email_msg_array;
    }
}
