<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailPoruke extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_poruke', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->dateTime('datum_vrijeme_poslano');
            $table->string('predmet', 255)->nullable();
            $table->longText('tijelo')->nullable();
            $table->bigInteger('email_predlosci_id')->index('fk_email_poruke_email_predlosci1_idx')->nullable();
            $table->bigInteger('from_korisnici_id')->index('fk_email_poruke_korisnici1_idx');
            $table->bigInteger('to_korisnici_id')->index('fk_email_poruke_korisnici2_idx');
            $table->bigInteger('cc_korisnici_id')->index('fk_email_poruke_korisnici3_idx')->nullable();
            $table->bigInteger('bcc_korisnici_id')->index('fk_email_poruke_korisnici4_idx')->nullable();
            $table->bigInteger('email_prilozi_id')->index('fk_email_poruke_email_prilozi1_idx')->nullable();
            $table->bigInteger('auto_poruke_postavke_id')->index('fk_email_poruke_auto_poruke_postavke1_idx')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
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
        Schema::dropIfExists('email_poruke');
    }
}
