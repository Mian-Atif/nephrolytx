<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCptcodeandrvuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cptcodeandrvu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cptcode',10)->nullable();
            $table->string('description',500)->nullable();
            $table->float('workRVU',6,2)->nullable();
            $table->float('practiceRVU',6,2)->nullable();
            $table->float('malpracticeRVU',6,2)->nullable();
            $table->float('totalRVU',6,2)->nullable();
        });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cptcodeandrvu');
    }
}
