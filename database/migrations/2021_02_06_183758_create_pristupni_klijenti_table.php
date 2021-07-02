<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePristupniKlijentiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pristupni_klijenti', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('naziv_unq', 150)->unique('naziv_unq_UNIQUE');
            $table->string('lozinka', 60);
            $table->string('lozinka_hash', 150);
            $table->bigInteger('istice');
            $table->char('omoguceno', 1);
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
        Schema::dropIfExists('pristupni_klijenti');
    }
}
