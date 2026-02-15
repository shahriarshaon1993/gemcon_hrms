<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeePersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_personal_infos', function (Blueprint $table) {
            $table->bigIncrements('id1');
            $table->string('employee_nid_name');
            $table->string('employee_nick_name');
            $table->string('employee_father_name');
            $table->string('employee_mother_name');
            $table->date('employee_dob_certificate');
            $table->date('employee_dob_actual');
            $table->integer('employee_marital_status');
            $table->date('employee_marriage_date');
            $table->string('employee_spouse_name');
            $table->integer('employee_children_no');
            $table->string('employee_nationality');
            $table->string('employee_religion');
            $table->string('employee_blood_group');
            $table->string('employee_mobile');
            $table->string('employee_email');
            $table->string('employee_height');
            $table->string('employee_weight');
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
        Schema::dropIfExists('employee_personal_infos');
    }
}
