<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_doctors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('person_id')->unsigned()->index('practice_doctors_person_id_foreign');
            $table->integer('practice_id')->unsigned()->index('practice_doctors_practice_id_foreign');
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
        Schema::dropIfExists('practice_doctors');
    }
}
