<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeAdressDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_adress_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ead_employee_id');
            $table->string('present_holding_no');
            $table->string('present_house_name');
            $table->string('present_road_no');
            $table->string('present_road_name');
            $table->string('present_vill_area');
            $table->string('present_ward_no');
            $table->string('present_union');
            $table->string('present_post_office');
            $table->string('present_thana');
            $table->string('present_district');
            $table->integer('present_mobile_2nd');
            $table->string('permanent_holding_no');
            $table->string('permanent_house_name');
            $table->string('permanent_road_no');
            $table->string('permanent_road_name');
            $table->string('permanent_vill_area');
            $table->string('permanent_ward_no');
            $table->string('permanent_union');
            $table->string('permanent_post_office');
            $table->string('permanent_thana');
            $table->string('permanent_district');
            $table->integer('permanent_mobile_3rd');
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
        Schema::dropIfExists('employee_adress_details');
    }
}
