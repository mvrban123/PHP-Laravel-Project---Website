<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ovlast extends Model
{
	use SoftDeletes;
    /*
     $table - definira na koju tablicu u baze se model odnosi
     $primaryKey - potrebno definirati koji je primarni ključ ako nije defaultni naziv ( default je 'id' )
     $timestamps - regulira automatsko spremanje u atribute created_at i updated_at (false - ne sprema, true - sprema)
    */
    protected $table = 'ovlasti';
    protected $primaryKey = 'id';
    // public $timestamps = false;

    /*
     definicija vanjskog ključa
     belongsTo() ima 3 parametra različita od hasOne()/hasMany()
     1. parametar - putanja do modela na koji je ključ povezan
     2. parametar - atribut OVOG modela s kojeg se povezuje
     3. parametar - atribut DRUGOG modela na koji se povezuje
    */
    public function funkcionalnosti()
    {
        return $this->belongsTo('App\Models\Funkcionalnost', 'funkcionalnosti_id', 'id');
    }

    public function uloge()
    {
        return $this->belongsTo('App\Models\Uloga', 'uloge_id', 'id');
    }

    public function razine_ovlasti()
    {
        return $this->belongsTo('App\Models\RazinaOvlasti', 'razine_ovlasti_id', 'id');
    }


}
