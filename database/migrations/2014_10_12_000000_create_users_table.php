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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
			$table->string('user_role');
			$table->smallInteger('user_status')->length(1)->unsigned();
			$table->string('signature');
			$table->integer('primary_bu')->length(3)->unsigned();
			$table->integer('secondary_bu')->length(3)->unsigned();
			$table->integer('primary_location')->length(3)->unsigned();
			$table->integer('secondary_location')->length(3)->unsigned();
			$table->integer('client_associated')->length(3)->unsigned();
			$table->integer('available_credits')->length(3)->unsigned();
			$table->timestamp('last_logged_in')->nullable();
			$table->timestamp('created_on')->nullable();
			$table->string('created_by');
			$table->timestamp('deleted_on')->nullable();
			$table->string('deleted_by');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
