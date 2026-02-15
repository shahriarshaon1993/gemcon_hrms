<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewBoardCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voidk
     */
    public function up()
    {
        Schema::create('interview_board_calls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ibc_circular_id');
            $table->string('ibc_examiner_name');
            $table->date('ibc_interview_date');
            $table->time('ibc_interview_time');
            $table->integer('ibc_email_status');
            $table->integer('ibc_status');
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
        Schema::dropIfExists('interview_calls');
    }
}
