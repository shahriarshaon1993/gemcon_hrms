<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('leave_from_date');
            $table->date('leave_to_date');
            $table->integer('leave_total_day');
            $table->integer('leave_type');
            $table->string('leave_reason');
            $table->integer('leave_apply_type');
            $table->tinyInteger('leave_with_holiday');
            $table->tinyInteger('leave_paystatus');
            $table->integer('leave_reliever');
            $table->integer('leave_reliever_contact');
            $table->string('leave_attachment');
            $table->string('leave_replace_date');
            $table->string('leave_apply_date');
            $table->tinyInteger('leave_apply_status');
            $table->tinyInteger('leave_app_status');
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

        Schema::create('leave_approval', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('leave_apply_id');
            $table->integer('leave_approve_by');
            $table->tinyInteger('leave_approve_status');
            $table->tinyInteger('leave_pay_status');
            $table->date('leave_approve_date');
            $table->string('leave_comments');
            $table->date('leave_view_date');
            $table->integer('leave_view_count');
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
        Schema::dropIfExists('leave_applications');
    }
}
