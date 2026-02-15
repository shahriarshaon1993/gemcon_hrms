<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeEducationalQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_educational_qualifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('eeq_employee_id');
            $table->string('eeq_degree_name');
            $table->string('eeq_major_group');
            $table->string('eeq_institute_name');
            $table->string('eeq_board_university');
            $table->date('eeq_session_from');
            $table->date('eeq_session_to');
            $table->integer('eeq_passing_year');
            $table->string('eeq_division_gpa');
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
        Schema::dropIfExists('employee_educational_qualifications');
    }
}
