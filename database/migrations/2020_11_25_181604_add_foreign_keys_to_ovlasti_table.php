<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOvlastiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ovlasti', function (Blueprint $table) {
            $table->foreign('funkcionalnosti_id', 'fk_ovlasti_funkcionalnosti1')->references('id')->on('funkcionalnosti')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('razine_ovlasti_id', 'fk_ovlasti_razine_ovlasti1')->references('id')->on('razine_ovlasti')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('uloge_id', 'fk_ovlasti_uloge1')->references('id')->on('uloge')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ovlasti', function (Blueprint $table) {
            $table->dropForeign('fk_ovlasti_funkcionalnosti1');
            $table->dropForeign('fk_ovlasti_razine_ovlasti1');
            $table->dropForeign('fk_ovlasti_uloge1');
        });
    }
}
