<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeProviderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_provider_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('address_1',255)->nullable();
            $table->string('address_2',255)->nullable();
//            $table->bigInteger('city_id')->unsigned()->nullable();
//            $table->bigInteger('state_id')->unsigned()->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('phone',15)->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('npi',10)->nullable();
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
        Schema::dropIfExists('practice_provider_details');
    }
}
