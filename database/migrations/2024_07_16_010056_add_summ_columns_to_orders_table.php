<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSummColumnsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('game_summ', 10, 2)->nullable()->after('status');
            $table->decimal('product_summ', 10, 2)->nullable()->after('game_summ');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('game_summ');
            $table->dropColumn('product_summ');
        });
    }
}
