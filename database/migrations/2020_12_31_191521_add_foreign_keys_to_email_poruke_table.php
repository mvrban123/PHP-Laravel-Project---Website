<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToEmailPorukeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_poruke', function (Blueprint $table) {
            $table->foreign('email_predlosci_id', 'fk_email_poruke_email_predlosci1')->references('id')->on('email_predlosci')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('from_korisnici_id', 'fk_email_poruke_korisnici1')->references('id')->on('korisnici')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('to_korisnici_id', 'fk_email_poruke_korisnici2')->references('id')->on('korisnici')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('cc_korisnici_id', 'fk_email_poruke_korisnici3')->references('id')->on('korisnici')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('bcc_korisnici_id', 'fk_email_poruke_korisnici4')->references('id')->on('korisnici')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('email_prilozi_id', 'fk_email_poruke_email_prilozi1')->references('id')->on('email_prilozi')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('auto_poruke_postavke_id', 'fk_email_poruke_auto_poruke_postavke1')->references('id')->on('auto_poruke_postavke')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_poruke', function (Blueprint $table) {
            $table->dropForeign('fk_email_poruke_email_predlosci1');
            $table->dropForeign('fk_email_poruke_korisnici1');
            $table->dropForeign('fk_email_poruke_korisnici2');
            $table->dropForeign('fk_email_poruke_korisnici3');
            $table->dropForeign('fk_email_poruke_korisnici4');
            $table->dropForeign('fk_email_poruke_email_prilozi1');
            $table->dropForeign('fk_email_poruke_auto_poruke_postavke1');
        });
    }
}
