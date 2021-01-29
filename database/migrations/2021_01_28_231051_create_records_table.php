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
            $table->timestamps();
            $table->softDeletes();
            $table->dateTime('date_in')->default(Carbon::now());
            $table->dateTime('date_out')->default(Carbon::now()->addDay(1));
            $table->foreignId('update_by')->nullable()->constrained('users');
            $table->foreignId('user_id');
            $table->foreignId('room_id');
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
