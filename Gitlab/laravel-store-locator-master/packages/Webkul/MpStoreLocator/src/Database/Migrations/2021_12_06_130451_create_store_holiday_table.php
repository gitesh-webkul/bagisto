<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreHolidayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_holiday', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('status',5)->default('A')->comment('A:Active , D:Disabled');
            $table->tinyInteger('date_type')->default(1)->comment('1:Single date , 2:Date Range');
            $table->date('date_from');
            $table->date('date_to')->nullable();
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
        Schema::dropIfExists('store_holiday');
    }
}
