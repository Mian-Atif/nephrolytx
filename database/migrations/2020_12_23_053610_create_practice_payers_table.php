<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticePayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_payers', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('practice_id')->nullable();
            $table->string('payer_name',250)->nullable();
            $table->string('payer_title',250)->nullable();
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
        Schema::dropIfExists('practice_payers');
    }
}
