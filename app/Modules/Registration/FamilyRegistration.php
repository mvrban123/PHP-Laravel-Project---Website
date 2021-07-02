<?php 

namespace App\Modules\Registration;

use App\Models\ObiteljskiIdentifikator;
use App\Models\Korisnik;
use App\Models\Adresa;
use App\Modules\Registration\RegistrationSession;
use App\Modules\Helpers\BaseAutoPorukeJobHelper;
use App\Events\FamilyRegistrationRequest;
use App\Jobs\AutoPorukaRegistracijaObiteljiJob;
use Illuminate\Http\Request;
use App\Http\Sanitizers\BaseSanitizer;
use App\Http\Validators\FamilyValidator;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class FamilyRegistration
{

    public function registerFamily(Request $request)
    {
        $requiredAction = '';
        $validationResult = false;
        $familyStored = false;
        $input = BaseSanitizer::sanitize($request->all());
        $famValidator = new FamilyValidator();

        /* Treba obraditi u podacima sesije:
            1) Zapisi ID-jeve roditelja (ne ako vec postoje i ako su isti)
            2) Obrisi ID-jeve djece
            3) Dodaj  ID-jeve novododane djece

            OVO TREBA RADITI I KOD CREATE I KOD UPDATE
        */
        /*
        $registrationSession = new RegistrationSession();  

        if ($registrationSession->hasKey($registrationSession->rod1IdDbLabel))
        {
            $requiredAction = 'update';
        }
        
        else
        {
            $requiredAction = 'create';
        }

        */
        $requiredAction = 'create';

        $validationResult = $famValidator->validate($input, $requiredAction);
        var_dump($validationResult);

        if($validationResult)
        {
            try
            {
                # TODO: OVO JE SAMO ZA TEST ZAKOMENTIRANO
                #$this->storeFamily($input);
                $familyStored = true;
            }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }
        }


        if ($familyStored)
        {

            # instanciranje helpera za ucitavanje postavki auto. poruke
            $jobHelperObj = new BaseAutoPorukeJobHelper(
                "uspjesna_registracija_obitelji"
            );

            # instanciranje job-a 
            $job = new AutoPorukaRegistracijaObiteljiJob();

            # okidanje job-a s pripadnim podacima
            $jobHelperObj->dispatchJob(
                $job,
                array(
                    'rod1' => $input['rod1'],
                    'rod2' => $input['rod2']
                )
            );
        }

        return $familyStored;
    }

    private function storeFamily($validatedInput)
    {
        $input = $validatedInput;
        $success = false;

        try
        {
            /* Početak transakcije */
            DB::beginTransaction();

            /* nova obitelj */
            $novaObiteljId = new ObiteljskiIdentifikator();
            $novaObiteljId->save();

            /* roditelj 1 */
            $novikorisnik1 = new Korisnik();
        
            $novikorisnik1->ime = $input['rod1']['name'];
            $novikorisnik1->prezime = $input['rod1']['lname'];
            $novikorisnik1->oib = $input['rod1']['oib'];
            $novikorisnik1->korisnicko_ime = $input['rod1']['username'];
            $novikorisnik1->lozinka_a2 = Hash::make(
                $input['rod1']['passwd']
            );
            $novikorisnik1->datum_rodenja =$input['rod1']['dob'];
            $novikorisnik1->spol_flag = $input['rod1']['gender'];
            $novikorisnik1->mobilni_telefon = $input['rod1']['phone'];
            $novikorisnik1->fiksni_telefon = $input['rod1']['tel'];
            $novikorisnik1->razine_obrazovanja_razina_obrazovanja_id = $input['rod1']['loedu'];
            $novikorisnik1->zanimanje = $input['rod1']['profession'];
            $novikorisnik1->bracni_status_flag = $input['rod1']['married'];
            $novikorisnik1->email = $input['rod1']['email'];
            $novikorisnik1->prima_obavijesti_flag = $input['rod1']['notify'];
            $novikorisnik1->zeli_aktivno_sudjelovati_flag = $input['rod1']['active_participant'];
            $novikorisnik1->napomena = $input['rod1']['reg_notes'];
            $novikorisnik1->radni_interesi = $input['rod1']['skills'];
            $novikorisnik1->potvrdeno_clanstvo_flag = $input['rod1']['confirmation'];
            $novikorisnik1->korisnici_roditelj_1 = NULL;
            $novikorisnik1->korisnici_roditelj_2 = NULL ;
            $novikorisnik1->datum_vrijeme_registracije = date('Y-m-d H:i:s');
            $novikorisnik1->uloge_uloga_id = 2;
            $novikorisnik1->obiteljski_identifikatori_id = $novaObiteljId->id;
            // uklonjeno!
            // $novikorisnik1->lozinka_sol = "sol";
            // $novikorisnik1->lozinka_SHA256 =$input['rod1']['passwd'];

            // adresa roditelja 1
            $adresa_rod1 = new Adresa();
    
            $adresa_rod1->ulica_broj = $input['rod1']['street_name'] . " " . $input['rod1']['street_number'];
    
            if($input['rod1']['rucniUnos'])
            {
                $adresa_rod1->grad_naselje = $input['rod1']['residence_place'];
                $adresa_rod1->drzava = $input['rod1']['country'];
                $adresa_rod1->postanski_broj = $input['rod1']['zip'];
                $adresa_rod1->rucni_unos = 1;
                $adresa_rod1->mjesta_id = NULL;
                $adresa_rod1->ulica_broj_dodatak = NULL;
            }
            else
            {
                $adresa_rod1->rucni_unos = 0;
                $adresa_rod1->mjesta_id = $input['rod1']['residence_id'];
                $adresa_rod1->ulica_broj_dodatak = NULL;
            }
    
            $adresa_rod1->save();
            $novikorisnik1->adrese_adresa_id = $adresa_rod1->id;
            $novikorisnik1->save();

            /* roditelj 2 */
            $novikorisnik2 = !empty($input['rod2']);
    
            if($novikorisnik2){
                $novikorisnik2 = new Korisnik();
    
                $novikorisnik2->ime = $input['rod2']['name'];
                $novikorisnik2->prezime = $input['rod2']['lname'];
                $novikorisnik2->oib = $input['rod2']['oib'];
                $novikorisnik2->korisnicko_ime = $input['rod2']['username'];
                $novikorisnik2->lozinka_a2 = Hash::make(
                    $input['rod2']['passwd']
                );
                $novikorisnik2->datum_rodenja =$input['rod2']['dob'];
                $novikorisnik2->spol_flag = $input['rod2']['gender'];
                $novikorisnik2->mobilni_telefon = $input['rod2']['phone'];
                $novikorisnik2->fiksni_telefon = $input['rod2']['tel'];
                $novikorisnik2->razine_obrazovanja_razina_obrazovanja_id = $input['rod2']['loedu'];
                $novikorisnik2->zanimanje = $input['rod2']['profession'];
                $novikorisnik2->bracni_status_flag = $input['rod2']['married'];
                $novikorisnik2->email = $input['rod2']['email'];
                $novikorisnik2->prima_obavijesti_flag = $input['rod2']['notify'];
                $novikorisnik2->zeli_aktivno_sudjelovati_flag = $input['rod2']['active_participant'];
                $novikorisnik2->napomena = $input['rod2']['reg_notes'];
                $novikorisnik2->radni_interesi = $input['rod2']['skills'];
                $novikorisnik2->potvrdeno_clanstvo_flag = $input['rod2']['confirmation'];
                $novikorisnik2->korisnici_roditelj_1 = NULL;
                $novikorisnik2->korisnici_roditelj_2 = NULL;
                $novikorisnik2->datum_vrijeme_registracije = date('Y-m-d H:i:s');
                $novikorisnik2->uloge_uloga_id = 2;
                $novikorisnik2->obiteljski_identifikatori_id = $novaObiteljId->id;
                // uklonjeno!
                // $novikorisnik2->lozinka_sol = "sol";
                // $novikorisnik2->lozinka_SHA256 =$input['rod2']['passwd'];

    
                if ($input['rod2']['same_address'])
                {
                    $novikorisnik2->adrese_adresa_id = $adresa_rod1->id;
                }
                else
                {
                    $adresa_rod2 = new Adresa();
    
                    $adresa_rod2->ulica_broj = $input['rod2']['street_name'] . " " . $input['rod2']['street_number'];
    
                    if($input['rod2']['rucniUnos'])
                    {
                        $adresa_rod2->grad_naselje = $input['rod2']['residence_place'];
                        $adresa_rod2->drzava = $input['rod2']['country'];
                        $adresa_rod2->postanski_broj = $input['rod2']['zip'];
                        $adresa_rod2->rucni_unos = 1;
                        $adresa_rod2->mjesta_id = NULL;
                        $adresa_rod2->ulica_broj_dodatak =  NULL;
                    }
                    else
                    {
                        $adresa_rod2->rucni_unos = 0;
                        $adresa_rod2->mjesta_id = $input['rod2']['residence_id'];
                        $adresa_rod2->ulica_broj_dodatak = NULL;
                    }
    
                    $adresa_rod2->save();
                    $novikorisnik2->adrese_adresa_id = $adresa_rod2->id;
                }
    
                $novikorisnik2->save();
            }
    
            foreach($input['djeca'] as $key)
            {
                $novo_dijete = new Korisnik();
    
                $novo_dijete->oib = $key['OIB'];
                $novo_dijete->ime = $key['ime'];
                $novo_dijete->prezime = $key['prezime'];
                $novo_dijete->datum_rodenja = $key['datum'];
                $novo_dijete->spol_flag = null;
                $novo_dijete->korisnici_roditelj_1 = $novikorisnik1->id;
                $novo_dijete->adrese_adresa_id = null;
                $novo_dijete->uloge_uloga_id = 3;
                $novo_dijete->obiteljski_identifikatori_id = $novaObiteljId->id;
                $novo_dijete->datum_vrijeme_registracije = date('Y-m-d H:i:s');
    
                if ($novikorisnik2)
                {
                    $novo_dijete->korisnici_roditelj_2 = $novikorisnik2->id;
                }
    
                $novo_dijete->save();
            }

            DB::commit();
            /* Kraj transakcije (ako je uspješna) */
            $success = true;
        }

        catch (Exception $e)
        {
            /* Rollback transakcije (ako je neuspješna) */
            DB::rollback();
            throw $e;
        }
        return $success;
    }
}