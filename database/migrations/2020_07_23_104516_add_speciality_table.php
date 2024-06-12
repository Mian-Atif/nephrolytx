<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecialityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

        public function up()
    {
        Schema::create('specialities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50)->nullable();
            $table->string('model_type',50)->comment('This Can be against multiple models');

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
        Schema::dropIfExists('specialities');

    }
}
