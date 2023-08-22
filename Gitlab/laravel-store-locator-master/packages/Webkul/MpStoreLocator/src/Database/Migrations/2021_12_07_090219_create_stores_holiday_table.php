<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresHolidayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores_holiday', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stores_id');
            $table->foreign('stores_id')->references('id')->on('stores')->onDelete('cascade');

            $table->unsignedBigInteger('store_holiday_id');
            $table->foreign('store_holiday_id')->references('id')->on('store_holiday')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores_holiday');
    }
}
