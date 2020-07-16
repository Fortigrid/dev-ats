<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
			$table->string('role_name')->unique();
			$table->string('business_unit');
			$table->string('location');
			$table->string('client');
			$table->string('site');
			$table->string('agency');
            $table->timestamp('created_on')->nullable();
			$table->string('created_by');
			$table->timestamp('deleted_on')->nullable();
			$table->string('deleted_by');
			$table->smallInteger('deleted_status')->length(1)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
