<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');

            // Agar userlar jadvali mavjud bo'lsa, foreign key qo'shishingiz mumkin
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            // Foreign key mavjud bo'lsa, avval uni o'chirish kerak
            // $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
