<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 191)->nullable();
            $table->string('last_name', 191)->nullable();
            $table->string('email', 191)->unique();
            $table->string('password', 191)->nullable();
            $table->boolean('status')->default(1);
            $table->string('confirmation_code', 191)->nullable();
            $table->boolean('confirmed')->default(0);
            $table->boolean('is_term_accept')->default(0)->comment(' 0 = not accepted,1 = accepted');
            $table->string('remember_token', 100)->nullable();
            $table->string('two_factor_code', 190)->nullable();
            $table->dateTime('two_factor_expires_at')->nullable();
            $table->timestamp('password_changed_at')->nullable();
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
        Schema::drop('users');
    }
}
