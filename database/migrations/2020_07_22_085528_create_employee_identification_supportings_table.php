<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeIdentificationSupportingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_identification_supportings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('eis_employee_id');
            $table->integer('nid_number');
            $table->date('nid_issue_renew_date');
            $table->date('nid_expiry_date');
            $table->integer('passport_number');
            $table->date('passport_issue_renew_date');
            $table->date('passport_expiry_date');
            $table->integer('driving_license_number');
            $table->date('driving_license_issue_renew_date');
            $table->date('driving_license_expiry_date');
            $table->integer('tin_number');
            $table->date('tin_issue_renew_date');
            $table->date('tin_expiry_date');
            $table->integer('birth_cer_number');
            $table->date('birth_cer_issue_renew_date');
            $table->date('birth_cer_expiry_date');
            $table->integer('branch_id');
            $table->integer('project_id');
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
        Schema::dropIfExists('employee_identification_supportings');
    }
}
