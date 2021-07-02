<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrilogPoruke extends Model
{
	use SoftDeletes;
    /*
     $table - definira na koju tablicu u baze se model odnosi
     $primaryKey - potrebno definirati koji je primarni ključ ako nije defaultni naziv ( default je 'id' )
     $timestamps - regulira automatsko spremanje u atribute created_at i updated_at (false - ne sprema, true - sprema)
    */
    protected $table = 'prilozi_poruka';
    protected $primaryKey = 'id';
    // public $timestamps = false;

    /*
     definicija vanjskog ključa
     belongsTo() ima 3 parametra različita od hasOne()/hasMany()
     1. parametar - putanja do modela na koji je ključ povezan
     2. parametar - atribut OVOG modela s kojeg se povezuje
     3. parametar - atribut DRUGOG modela na koji se povezuje
    */
    public function email_prilozi()
    {
        return $this->belongsTo('App\Models\EmailPrilog', 'email_prilozi_id', 'id');
    }

    public function email_poruke()
    {
        return $this->belongsTo('App\Models\EmailPoruka', 'email_poruke_id', 'id');
    }
}
