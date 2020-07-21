<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_templates', function (Blueprint $table) {
            $table->id();
			$table->integer('business_unit_id')->unsigned();
			$table->string('template_name');
			$table->string('header_image');
			$table->string('content_bg_color')->nullable();
			$table->string('footer_image');
			$table->tinyInteger('status')->length(1)->unsigned()->default(1);
            $table->timestamp('created_on');
			$table->string('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_templates');
    }
}
