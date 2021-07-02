<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Korisnik extends Model
{
    use SoftDeletes;
    
    /*
     $table - definira na koju tablicu u baze se model odnosi
     $primaryKey - potrebno definirati koji je primarni ključ ako nije defaultni naziv ( default je 'id' )
     $timestamps - regulira automatsko spremanje u atribute created_at i updated_at (false - ne sprema, true - sprema)
    */
    protected $table = 'korisnici';
    protected $primaryKey = 'id';
    // public $timestamps = false;


    /*
     definicija vanjskog ključa
     belongsTo() ima 3 parametra različita od hasOne()/hasMany()
     1. parametar - putanja do modela na koji je ključ povezan
     2. parametar - atribut OVOG modela s kojeg se povezuje
     3. parametar - atribut DRUGOG modela na koji se povezuje
    */
    public function adrese()
    {
        return $this->belongsTo('App\Models\Adresa', 'adrese_adresa_id', 'id');
    }

    public function uloge()
    {
        return $this->belongsTo('App\Models\Uloga', 'uloge_uloga_id', 'id');
    }

    public function razine_obrazovanja()
    {
        return $this->belongsTo('App\Models\RazinaObrazovanja', 'razine_obrazovanja_razina_obrazovanja_id', 'id');
    }

    public function obiteljski_identifikatori()
    {
        return $this->belongsTo('App\Models\ObiteljskiIdentifikator', 'obiteljski_identifikatori_id', 'id');
    }

    public function email_predlosci()
    {
        return $this->hasMany('App\Models\EmailPredlozak', 'korisnici_id', 'id');
    }

    public function email_poruka_from()
    {
        return $this->hasMany('App\Models\EmailPoruka', 'from_korisnici_id', 'id');
    }

    public function email_poruka_to()
    {
        return $this->hasMany('App\Models\EmailPoruka', 'to_korisnici_id', 'id');
    }

    public function email_poruka_cc()
    {
        return $this->hasMany('App\Models\EmailPoruka', 'cc_korisnici_id', 'id');
    }

    public function email_poruka_bcc()
    {
        return $this->hasMany('App\Models\EmailPoruka', 'bcc_korisnici_id', 'id');
    }

    public function pristupni_klijenti_korisnika()
    {
        return $this->hasMany('App\Models\PristupniKlijentKorisnika', 'korisnici_id', 'id');
    }
}
