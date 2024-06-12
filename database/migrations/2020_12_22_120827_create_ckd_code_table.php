<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCkdCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ckd_code', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ckdcode',10)->nullable();
            $table->string('codeName',40)->nullable();

        });
        DB::table('ckd_code')->insert(['id'=>1, 'ckdcode'=> 'N18.1', 'codeName'=>'CKD'],
            ['id'=>2, 'ckdcode'=> 'N181', 'codeName'=>'CKD'],
            [3, 'ckdcode'=> 'N18.2', 'codeName'=>'CKD'],
            [4, 'ckdcode'=> 'N182', 'codeName'=>'CKD'],
            [5, 'ckdcode'=> 'N18.3', 'codeName'=>'CKD'],
            [6, 'ckdcode'=> 'N183', 'codeName'=>'CKD'],
            [7, 'ckdcode'=> 'N18.4', 'codeName'=>'CKD'],
            [8, 'ckdcode'=> 'N184', 'codeName'=>'CKD'],
            [9, 'ckdcode'=> 'N18.5', 'codeName'=>'CKD'],
            [10, 'ckdcode'=> 'N18.6', 'codeName'=>'ESRD'],
            [11, 'ckdcode'=> 'N186', 'codeName'=>'ESRD']);

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ckd_code');
    }
}
