<?php 

namespace App\Modules;
use App\Models\Korisnik;
use App\Models\Adresa;
use Illuminate\Http\Request;
use App\Http\Controllers\DbControllers\KorisnikController;

class BaseRegistration
{
    public static function RegisterUser($userData)
    {
        /*
            TODO: 
            0.1. Sanitiziraj podatke 

            0.2. Validiraj podatke

            1. Provjeri postoji li *USPJEŠNO REGISTRIRANI KORISNIK U BP* s navedenim /username/ i /email/?
                DA -> Vrati response da takav korisnik već postoji!
                NE -> nastavi dalje na 2.

            2. Preuzmi do sada unešene podatke korisnika i ako je *POZIV IZVRŠEN S POSLJEDNJEG KORAKA REGISTRACIJE*?
                DA -> nastavi na 3.
                NE -> nastavi na 4.

            3. Provjeri još jednom postoji li takav korisnik/korisnici u BP (dakle, roditelji username i email)
                DA -> Vrati response da takav korisnik već postoji!
                NE -> Spremi podatke *+ POŠALJI EMAIL O POTVRDI REGISTRACIJE*
                    potrebno je okinuti događaj za slanje email-a
                    *za ovo će trebati još jedna 'ruta' na koju se šalje potvrda o verifikaciji zahtjeva, ali ovo kasnije tek*

            4. Provjeri još jednom postoji li takav korisnik/korisnici u BP (dakle, roditelji username i email)
                DA -> Vrati response da takav korisnik već postoji!
                NE -> Spremi podatke koje imaš
        */

    }


}


class A {
    public static function bok(){echo "bok";}
    public static function dvobok()
    {
        self::bok();
    }
}

class B extends A
{
    public static function bok(){echo "overrajdani bok";}
    public static function kae() 
    {
        parent::dvobok();
    }
}

B::kae();