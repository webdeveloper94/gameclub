<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePordersTable extends Migration
{
    public function up()
    {
        Schema::create('porders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('product_total');
            $table->decimal('product_summ', 10, 2);
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    public function down()
    {
        Schema::dropIfExists('porders');
    }
}
