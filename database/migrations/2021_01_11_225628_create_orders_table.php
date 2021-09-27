<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('order_status_id');
            $table->string('consumer_phone');
            $table->string('consumer_name');
            $table->string('consumer_ville');
            $table->integer('product_id');
            $table->json("note_json")->nullable();
            $table->integer('shipping_id')->nullable();
            $table->json("shipping_json")->nullable();
            $table->integer('quantity');
            $table->double('total');
            $table->double('subTotal');
            $table->string("shipping_adresse")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
