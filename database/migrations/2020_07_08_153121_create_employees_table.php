<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
public function up()
{
Schema::create('employees', function (Blueprint $table) {
	$table->bigIncrements('id');
	$table->integer('employee_id');
	$table->string('employee_fullname');
	$table->integer('employee_sbu');
	$table->integer('employee_department');
	$table->integer('employee_designation');
	$table->integer('employee_job_grade');
	$table->string('employee_mobile');
	$table->integer('employee_reporting_to');
	$table->string('employee_joining_date');
	$table->integer('employee_machine_id');
	$table->integer('employee_status');
	$table->integer('employee_leave_group');
	$table->string('employee_work_location');
	$table->string('employee_image')->nullable();
	$table->integer('employee_remarks');
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
Schema::dropIfExists('employees');
}
}
