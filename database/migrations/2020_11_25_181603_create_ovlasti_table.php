<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvlastiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ovlasti', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('uloge_id');
            //$table->integer('funkcionalnosti_id')->unique('funkcionalnosti_id_UNIQUE');
            //$table->integer('razine_ovlasti_id')->index('fk_ovlasti_razine_ovlasti1_idx');
            $table->integer('funkcionalnosti_id');
            $table->integer('razine_ovlasti_id');
            $table->dateTime('created_at');
            $table->softDeletes();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['uloge_id', 'funkcionalnosti_id']);    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ovlasti');
    }
}
