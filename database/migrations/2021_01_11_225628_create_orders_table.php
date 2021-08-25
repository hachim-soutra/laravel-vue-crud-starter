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
            $table->string('status');
            $table->string('package');
            $table->integer('source_id');
            $table->integer('consumer_id');
            $table->integer('product_id');
            $table->json("upsell_json");
            $table->json("note_json");
            $table->integer('shipping_id');
            $table->json("shipping_json");
            $table->integer('quantity');
            $table->double('total');
            $table->double('subTotal');
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
