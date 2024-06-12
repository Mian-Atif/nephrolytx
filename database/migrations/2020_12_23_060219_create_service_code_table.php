<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_code', function (Blueprint $table) {
            $table->integer('id');
            $table->string('cptcode')->nullable();
            $table->string('serviceName')->nullable();
            $table->integer('orderby')->nullable();
            $table->integer('service_id')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_code');
    }
}
