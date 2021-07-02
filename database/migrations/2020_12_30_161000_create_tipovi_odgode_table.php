<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoviOdgodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipovi_odgode', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('txt_id', 45)->nullable()->unique('txt_id_UNIQUE');
            $table->string('naziv', 255);
            $table->char('odgodjeno', 1);
            $table->integer('minute')->nullable();
            $table->char('fiksni_interval', 1);
            $table->string('cron_izraz', 100)->nullable();
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
        Schema::dropIfExists('tipovi_odgode');
    }
}
