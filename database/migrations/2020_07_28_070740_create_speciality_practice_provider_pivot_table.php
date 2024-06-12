<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialityPracticeProviderPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speciality_practice_provider', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('speciality_id')->unsigned()->nullable();
            $table->bigInteger('source_id')->unsigned()->nullable();
            $table->enum('type', ['practice', 'provider'])->default(null);
            $table->softDeletes();
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
        Schema::dropIfExists('speciality_practice_provider');
    }
}
