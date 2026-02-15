<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeFamilyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_family_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('efd_employee_id');
            $table->string('efd_family_member_name');
            $table->string('efd_relationship');
            $table->date('efd_date_of_birth');
            $table->string('efd_occupation');
            $table->integer('efd_contact_mobile_no');
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
        Schema::dropIfExists('employee_family_details');
    }
}
