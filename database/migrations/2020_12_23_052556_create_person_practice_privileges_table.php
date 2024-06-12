<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonPracticePrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_practice_privileges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('practice_id')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->bigInteger('doctor_id')->nullable();
            $table->bigInteger('person_id')->nullable();
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
        Schema::dropIfExists('person_practice_privileges');
    }
}
