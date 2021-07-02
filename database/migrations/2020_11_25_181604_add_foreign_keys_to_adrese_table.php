<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAdreseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adrese', function (Blueprint $table) {
            $table->foreign('mjesta_id', 'fk_adrese_mjesta1')->references('id')->on('mjesta')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adrese', function (Blueprint $table) {
            $table->dropForeign('fk_adrese_mjesta1');
        });
    }
}
