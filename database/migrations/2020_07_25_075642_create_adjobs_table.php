<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjobs', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no');
			$table->string('job_title');
			$table->string('broadcast');
			$table->string('job_type');
			$table->string('job_time');
			$table->string('bp1');
			$table->string('bp2');
			$table->string('bp3');
			$table->date('sdate');
			$table->date('edate');
			$table->string('board');
			$table->string('industry');
			$table->string('job_class');
			$table->string('currency');
			$table->string('min');
			$table->string('max');
			$table->string('salary_per');
			$table->string('salary_desc');
			$table->string('hide_salary');
			$table->text('job_requirement');
			$table->string('min_exp');
			$table->string('edu_level');
			$table->string('local_resident');
			$table->string('location');
			$table->string('postcode');
			$table->string('video_url');
			$table->text('job_summary');
			$table->text('detail_job_summary');
			$table->string('location_city');
			$table->string('job_template');
			$table->dateTime('post_time');
			$table->string('contact_email');
			$table->string('contact_phone');
			$table->string('cost');
			$table->tinyInteger('active')->length(1)->unsigned()->default(1);
			$table->timestamp('created_on')->nullable();
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
        Schema::dropIfExists('adjobs');
    }
}
