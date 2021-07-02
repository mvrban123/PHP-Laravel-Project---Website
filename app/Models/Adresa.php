<?php

// put models in a different namespace https://stackoverflow.com/a/44080541
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adresa extends Model
{
	use SoftDeletes;

    /*
     $table - definira na koju tablicu u baze se model odnosi
     $primaryKey - potrebno definirati koji je primarni ključ ako nije defaultni naziv ( default je 'id' )
     $timestamps - regulira automatsko spremanje u atribute created_at i updated_at (false - ne sprema, true - sprema)
    */
    protected $table = 'adrese';
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
        return $this->hasMany('App\Models\Korisnik', 'adrese_adresa_id', 'id');
    }

    public function mjesta()
    {
        return $this->belongsTo('App\Models\Mjesto', 'mjesta_id', 'id');
    }

}
