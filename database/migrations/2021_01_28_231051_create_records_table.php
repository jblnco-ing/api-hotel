<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('update_by')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->foreign('update_by')->references('id')->on('users');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->dateTime('date_in')->default(Carbon::now());
            $table->dateTime('date_out')->default(Carbon::now()->addDay(1));
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('records');
    }
}
