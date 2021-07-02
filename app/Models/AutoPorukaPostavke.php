<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutoPorukaPostavke extends Model
{
	use SoftDeletes;

    /*
     $table - definira na koju tablicu u baze se model odnosi
     $primaryKey - potrebno definirati koji je primarni ključ ako nije defaultni naziv ( default je 'id' )
     $timestamps - regulira automatsko spremanje u atribute created_at i updated_at (false - ne sprema, true - sprema)
    */
    protected $table = 'auto_poruke_postavke';
    protected $primaryKey = 'id';
    // public $timestamps = false;

    /*
     definicija vanjskog ključa
     hasMany() ima 3 parametra različita od belongsTo()
     1. parametar - putanja do modela na koji je ključ povezan
     2. parametar - atribut DRUGOG modela na koji se povezuje
     3. parametar - atribut OVOG modela s kojeg se povezuje
    */
    public function email_predlosci()
    {
        return $this->belongsTo('App\Models\EmailPredlozak', 'email_predlosci_id', 'id');
    }

    public function tipovi_odgode()
    {
        return $this->belongsTo('App\Models\TipOdgode', 'tipovi_odgode_id', 'id');
    }

    public function email_poruke()
    {
        return $this->hasMany('App\Models\EmailPoruka', 'auto_poruke_postavke_id', 'id');
    }
}