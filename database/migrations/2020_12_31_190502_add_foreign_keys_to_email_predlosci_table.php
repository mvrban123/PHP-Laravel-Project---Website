<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToEmailPredlosciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_predlosci', function (Blueprint $table) {
            $table->foreign('kategorije_predlozaka_id', 'fk_email_predlosci_kategorije_predlozaka1')->references('id')->on('kategorije_predlozaka')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('korisnici_id', 'fk_email_predlosci_korisnici1')->references('id')->on('korisnici')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('email_prilozi_id', 'fk_email_predlosci_email_prilozi1')->references('id')->on('email_prilozi')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_predlosci', function (Blueprint $table) {
            $table->dropForeign('fk_email_predlosci_kategorije_predlozaka1');
            $table->dropForeign('fk_email_predlosci_korisnici1');
            $table->dropForeign('fk_email_predlosci_email_prilozi1');
        });
    }
}
