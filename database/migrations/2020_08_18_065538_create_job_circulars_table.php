<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobCircularsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_circulars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jc_company_name');
            $table->string('jc_circular_id');
            $table->integer('jc_job_position');
            $table->integer('jc_job_vacancy');
            $table->string('jc_job_description');
            $table->string('jc_job_responsibility');
            $table->string('jc_applied_requirements');
            $table->integer('jc_job_nature');
            $table->string('jc_job_requirements');
            $table->string('jc_educational_requirements');
            $table->string('jc_experience_requirements');
            $table->integer('jc_job_location');
            $table->string('jc_salary_range');
            $table->string('jc_other_benefits');
            $table->date('jc_circular_publish_date');
            $table->date('jc_circular_expired_date');
            $table->integer('jc_person_assign');
            $table->integer('jc_exam_type');
            $table->integer('jc_circular_status');

            $table->integer('project_id');
            $table->integer('branch_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
            $table->timestamp('deleted_at')->nullable();
            $table->integer('valid')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_circulars');
    }
}
