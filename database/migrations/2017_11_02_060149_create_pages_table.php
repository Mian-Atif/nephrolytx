<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 191);
            $table->string('page_slug', 191)->unique();
            $table->longText('description')->nullable();
            $table->string('cannonical_link', 191)->nullable();
            $table->string('seo_title', 191)->nullable();
            $table->string('seo_keyword', 191)->nullable();
            $table->longText('seo_description')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
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

        Schema::drop('pages');
    }
}
