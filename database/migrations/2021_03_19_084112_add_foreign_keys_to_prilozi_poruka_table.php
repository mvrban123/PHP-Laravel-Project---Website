<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToPriloziPorukaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prilozi_poruka', function (Blueprint $table) {
            $table->foreign('email_prilozi_id', 'fk_prilozi_poruka_email_prilozi1')->references('id')->on('email_prilozi')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign('email_poruke_id', 'fk_prilozi_poruka_email_poruke1')->references('id')->on('email_poruke')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prilozi_poruka', function (Blueprint $table) {
            $table->dropForeign('fk_prilozi_poruka_email_prilozi1');
            $table->dropForeign('fk_prilozi_poruka_email_poruke1');
        });
    }
}
