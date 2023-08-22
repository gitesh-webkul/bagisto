<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->char('status',1)->default('A')->comment('A:Enabled , D:Disabled');
            $table->string('store_name');
            $table->string('store_lat')->nullable();
            $table->string('store_long')->nullable();
            $table->text('description')->nullable();
            $table->char('urgent_closed',1)->default('Y')->comment('Y:YES , N:NO');
            $table->tinyInteger('store_opens')->default(1)->comment('1:24*7 , 2:custom day with same time , 3: custom day with custom time');
            $table->json('same_timing')->nullable();
            $table->json('different_timing')->nullable();
            $table->string('person_name')->nullable();
            $table->string('person_email')->nullable();
            $table->string('person_mobile')->nullable();
            $table->string('person_fax')->nullable();
            $table->string('address_country')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_city')->nullable();
            $table->text('address_street')->nullable();
            $table->text('address_postal_code')->nullable();

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
        Schema::dropIfExists('stores');
    }
}
