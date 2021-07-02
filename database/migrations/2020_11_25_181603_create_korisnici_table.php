<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKorisniciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('korisnici', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('ime', 45)->nullable();
            $table->string('prezime', 45)->nullable();
            $table->char('oib', 11)->nullable()->unique('oib_UNIQUE');
            $table->date('datum_rodenja')->nullable();
            $table->char('spol_flag', 1)->nullable();
            $table->string('mobilni_telefon', 45)->nullable();
            $table->string('fiksni_telefon', 45)->nullable();
            $table->string('zanimanje', 45)->nullable();
            $table->char('bracni_status_flag', 1)->nullable();
            $table->char('prima_obavijesti_flag', 1)->nullable();
            $table->char('zeli_aktivno_sudjelovati_flag', 1)->nullable();
            $table->char('potvrdeno_clanstvo_flag', 1)->nullable();
            $table->string('korisnicko_ime', 45)->nullable()->unique('korisnicko_ime_UNIQUE');
            $table->string('lozinka_a2', 150)->nullable();
            $table->string('lozinka_s1', 60)->nullable();
            $table->string('email', 45)->nullable();
            $table->string('pwd_reset_sig', 150)->nullable();
            $table->char('pwd_reset_used', 1)->nullable();
            $table->dateTime('datum_vrijeme_registracije')->nullable();
            $table->text('napomena')->nullable();
            $table->text('radni_interesi')->nullable();
            $table->bigInteger('adrese_adresa_id')->index('fk_korisnici_adrese_idx')->nullable();
            $table->integer('razine_obrazovanja_razina_obrazovanja_id')->index('fk_korisnici_razine_obrazovanja1_idx')->nullable();
            $table->integer('uloge_uloga_id')->index('fk_korisnici_uloge1_idx');
            $table->bigInteger('korisnici_roditelj_1')->index('fk_korisnici_korisnici1_idx')->nullable();
            $table->bigInteger('korisnici_roditelj_2')->index('fk_korisnici_korisnici1_idx1')->nullable();
            $table->bigInteger('obiteljski_identifikatori_id')->index('fk_korisnici_obiteljski_identifikatori1_idx')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            // maknuto jer Laravel koristi sol u svojim metodama za generiranje Hash-a lozinke
            // $table->string('lozinka_sol', 45)->nullable();

            // Laravel koristi bcrypt i Blowfish, koji daju hash duljine 60 znakova
            // $table->string('lozinka_SHA256', 65)->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('korisnici');
    }
}
