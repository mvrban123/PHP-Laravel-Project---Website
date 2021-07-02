<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailPredlosci extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_predlosci', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->text('naslov')->nullable();
            $table->longText('definicija')->nullable();
            $table->bigInteger('kategorije_predlozaka_id')->index('fk_email_predlosci_kategorije_predlozaka1_idx')->nullable();
            $table->bigInteger('korisnici_id')->index('fk_email_predlosci_korisnici1_idx');
            $table->bigInteger('email_prilozi_id')->index('fk_email_predlosci_email_prilozi1_idx')->nullable();
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
        Schema::dropIfExists('email_predlosci');
    }
}
