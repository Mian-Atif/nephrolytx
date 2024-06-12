<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCptcodePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cptcode_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cpt_code',10)->nullable();
            $table->float('par_amount',8,2)->nullable();
            $table->integer('practice_id')->nullable();
            $table->string('state',5)->nullable();
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
        Schema::dropIfExists('cptcode_prices');
    }
}
