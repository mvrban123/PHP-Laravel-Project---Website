<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMjestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mjesta', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('naziv');
            $table->string('postanski_broj', 20);
            $table->integer('drzave_id')->index('fk_mjesta_drzave1_idx');
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
        Schema::dropIfExists('mjesta');
    }
}
