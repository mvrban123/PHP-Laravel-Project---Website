<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoPorukePostavkeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_poruke_postavke', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->char('omoguceno', 1);
            $table->string('naziv')->nullable();
            $table->string('opis')->nullable();
            $table->bigInteger('email_predlosci_id')->index('fk_auto_poruke_postavke_email_predlosci1_idx')->nullable();
            $table->integer('tipovi_odgode_id')->index('fk_auto_poruke_postavke_tipovi_odgode1_idx');
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
        Schema::dropIfExists('auto_poruke_postavke');
    }
}