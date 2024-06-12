<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeBillingManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_billing_manager', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('person_id')->unsigned()->index('practice_billing_manager_person_id_foreign');
            $table->integer('practice_id')->unsigned()->index('practice_billing_manager_practice_id_foreign');
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
        Schema::dropIfExists('practice_billing_manager');
    }
}
