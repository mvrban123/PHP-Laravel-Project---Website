<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMjestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mjesta', function (Blueprint $table) {
            $table->foreign('drzave_id', 'fk_mjesta_drzave1')->references('id')->on('drzave')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mjesta', function (Blueprint $table) {
            $table->dropForeign('fk_mjesta_drzave1');
        });
    }
}
