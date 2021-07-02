<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdreseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adrese', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('ulica_broj', 45);
            $table->string('ulica_broj_dodatak', 20)->nullable();
            $table->text('grad_naselje')->nullable();
            $table->text('drzava')->nullable();
            $table->string('postanski_broj', 20)->nullable();
            $table->char('rucni_unos', 1);
            $table->integer('mjesta_id')->index('fk_adrese_mjesta1_idx')->nullable();
            $table->dateTime('created_at');
            $table->softDeletes();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adrese');
    }
}
