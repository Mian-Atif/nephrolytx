<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location_name', 255)->nullable();
            $table->string('location_map', 255)->nullable();
            $table->integer('practice_id')->unsigned()->index('practice_locations_practice_id_foreign');
            $table->string('email')->nullable();
            $table->string('npi')->nullable();
            $table->string('phone')->nullable();

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
        Schema::dropIfExists('practice_locations');
    }
}
