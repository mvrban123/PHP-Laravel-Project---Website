<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriloziPredlozakaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prilozi_predlozaka', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->timestamps();
            $table->bigInteger('email_prilozi_id');
            $table->bigInteger('email_predlosci_id');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->softDeletes();
            $table->unique(['email_prilozi_id', 'email_predlosci_id']); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prilozi_predlozaka');
    }
}
