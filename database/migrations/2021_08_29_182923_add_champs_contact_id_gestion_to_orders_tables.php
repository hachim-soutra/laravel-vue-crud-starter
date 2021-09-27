<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChampsContactIdGestionToOrdersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('contact_id')->nullable();
            $table->integer('gestion_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->dateTime('date_reporting')->nullable();
            $table->dateTime('dateConfirmation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('contact_id');
            $table->dropColumn('gestion_id');
        });
    }
}
