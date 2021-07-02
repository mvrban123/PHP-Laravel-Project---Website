<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToKorisniciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('korisnici', function (Blueprint $table) {
            $table->foreign('adrese_adresa_id', 'fk_korisnici_adrese')->references('id')->on('adrese')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('korisnici_roditelj_1', 'fk_korisnici_korisnici_rod1')->references('id')->on('korisnici')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('korisnici_roditelj_2', 'fk_korisnici_korisnici_rod2')->references('id')->on('korisnici')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('razine_obrazovanja_razina_obrazovanja_id', 'fk_korisnici_razine_obrazovanja1')->references('id')->on('razine_obrazovanja')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('uloge_uloga_id', 'fk_korisnici_uloge1')->references('id')->on('uloge')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('obiteljski_identifikatori_id', 'fk_korisnici_obiteljski_identifikatori1')->references('id')->on('obiteljski_identifikatori')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('korisnici', function (Blueprint $table) {
            $table->dropForeign('fk_korisnici_adrese');
            $table->dropForeign('fk_korisnici_korisnici_rod1');
            $table->dropForeign('fk_korisnici_korisnici_rod2');
            $table->dropForeign('fk_korisnici_razine_obrazovanja1');
            $table->dropForeign('fk_korisnici_uloge1');
            $table->dropForeign('fk_korisnici_obiteljski_identifikatori1');
        });
    }
}
