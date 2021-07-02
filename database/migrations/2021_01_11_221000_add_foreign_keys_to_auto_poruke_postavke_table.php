<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToAutoPorukePostavkeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auto_poruke_postavke', function (Blueprint $table) {
            $table->foreign('email_predlosci_id', 'fk_auto_poruke_postavke_email_predlosci1')->references('id')->on('email_predlosci')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('tipovi_odgode_id', 'fk_auto_poruke_postavke_tipovi_odgode1')->references('id')->on('tipovi_odgode')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auto_poruke_postavke', function (Blueprint $table) {
            $table->dropForeign('fk_auto_poruke_postavke_email_predlosci1');
            $table->dropForeign('fk_auto_poruke_postavke_tipovi_odgode1');
        });
    }
}