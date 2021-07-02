<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailPoruka extends Model
{
	use SoftDeletes;

    /*
     $table - definira na koju tablicu u baze se model odnosi
     $primaryKey - potrebno definirati koji je primarni ključ ako nije defaultni naziv ( default je 'id' )
     $timestamps - regulira automatsko spremanje u atribute created_at i updated_at (false - ne sprema, true - sprema)
    */
    protected $table = 'email_poruke';
    protected $primaryKey = 'id';
    // public $timestamps = false;

    /*
     definicija vanjskog ključa
     belongsTo() ima 3 parametra različita od hasOne()/hasMany()
     1. parametar - putanja do modela na koji je ključ povezan
     2. parametar - atribut OVOG modela s kojeg se povezuje
     3. parametar - atribut DRUGOG modela na koji se povezuje
    */
    public function korisnici_from()
    {
        return $this->belongsTo('App\Models\Korisnik', 'from_korisnici_id', 'id');
    }

    public function korisnici_to()
    {
        return $this->belongsTo('App\Models\Korisnik', 'to_korisnici_id', 'id');
    }

    public function korisnici_cc()
    {
        return $this->belongsTo('App\Models\Korisnik', 'cc_korisnici_id', 'id');
    }
    
    public function korisnici_bcc()
    {
        return $this->belongsTo('App\Models\Korisnik', 'bcc_korisnici_id', 'id');
    }

    public function email_predlosci()
    {
        return $this->belongsTo('App\Models\EmailPredlozak', 'email_predlosci_id', 'id');
    }

    public function prilozi_poruka()
    {
        return $this->has_many('App\Models\PrilogPoruke', 'email_poruka_id', 'id');
    }

    public function auto_poruke_postavke()
    {
        return $this->belongsTo('App\Models\AutoPorukaPostavke', 'auto_poruke_postavke_id', 'id');
    }
}