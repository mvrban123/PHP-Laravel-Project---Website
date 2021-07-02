<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailPredlozak extends Model
{
	use SoftDeletes;
    
    /*
     $table - definira na koju tablicu u baze se model odnosi
     $primaryKey - potrebno definirati koji je primarni ključ ako nije defaultni naziv ( default je 'id' )
     $timestamps - regulira automatsko spremanje u atribute created_at i updated_at (false - ne sprema, true - sprema)
    */
    protected $table = 'email_predlosci';
    protected $primaryKey = 'id';
    // public $timestamps = false;

    /*
     definicija vanjskog ključa
     hasMany() ima 3 parametra različita od belongsTo()
     1. parametar - putanja do modela na koji je ključ povezan
     2. parametar - atribut DRUGOG modela na koji se povezuje
     3. parametar - atribut OVOG modela s kojeg se povezuje
    */
    public function korisnici()
    {
        return $this->belongsTo('App\Models\Korisnik', 'korisnici_id', 'id');
    }

    public function kategorije_predlozaka()
    {
        return $this->belongsTo('App\Models\KategorijaPredloska', 'kategorije_predlozaka_id', 'id');
    }

    public function prilozi_predlozaka()
    {
        return $this->has_many('App\Models\PrilogPredloska', 'email_predlozak_id', 'id');
    }

    public function email_poruke()
    {
        return $this->hasMany('App\Models\EmailPoruka', 'email_predlosci_id', 'id');
    }

    public function auto_poruke_postavke()
    {
        return $this->belongsTo('App\Models\AutoPorukaPostavke', 'email_predlosci_id', 'id');
    }
}
