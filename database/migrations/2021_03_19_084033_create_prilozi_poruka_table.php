<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriloziPorukaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prilozi_poruka', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('email_prilozi_id');
            $table->bigInteger('email_poruke_id');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->softDeletes();
            $table->unique(['email_prilozi_id', 'email_poruke_id']); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prilozi_poruka');
    }
}
