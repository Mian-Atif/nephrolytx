<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('addressable_id')->nullable();
            $table->string('addressable_type',100)->nullable();
            $table->string('	title',255)->nullable();
            $table->string('	address1',255)->nullable();
            $table->string('	address2',255)->nullable();
            $table->string('	city',100)->nullable();
            $table->string('	state',100)->nullable();
            $table->string('	zip',50)->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
