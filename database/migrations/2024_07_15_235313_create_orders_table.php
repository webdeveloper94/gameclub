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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('game_id');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedBigInteger('product_id')->nullable(); // Nullable field
            $table->decimal('product_total', 10, 2)->nullable(); // Nullable field
            $table->string('status');
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('product_id')->references('id')->on('products')->nullable(); // Nullable foreign key
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
