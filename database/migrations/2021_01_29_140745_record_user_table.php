<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecordUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_user', function (Blueprint $table) {
            $table->unsignedBigInteger('record_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('record_id')->references('id')->on('records');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('record_user');
    }
}
