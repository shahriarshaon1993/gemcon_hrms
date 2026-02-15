<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_references', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('er_employee_id');
            $table->string('er_name1');
            $table->string('er_relationship1');
            $table->string('er_occupation1');
            $table->string('er_designation_department1');
            $table->string('er_company_address1');
            $table->integer('er_mobile_no1');
            $table->string('er_holding_no1');
            $table->string('er_road_no1');
            $table->string('er_house_name1');
            $table->string('er_road_name1');
            $table->integer('er_ward_no1');
            $table->string('er_union_pouro_city1');
            $table->string('er_post_office1');
            $table->string('er_thana1');
            $table->string('er_district1');
            $table->integer('er_nid_no1');
            $table->string('er_name2');
            $table->string('er_relationship2');
            $table->string('er_occupation2');
            $table->string('er_designation_department2');
            $table->string('er_company_address2');
            $table->integer('er_mobile_no2');
            $table->string('er_holding_no2');
            $table->string('er_road_no2');
            $table->string('er_house_name2');
            $table->string('er_road_name2');
            $table->integer('er_ward_no2');
            $table->string('er_union_pouro_city2');
            $table->string('er_post_office2');
            $table->string('er_thana2');
            $table->string('er_district2');
            $table->integer('er_nid_no2');
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
        Schema::dropIfExists('employee_references');
    }
}
