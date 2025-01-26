<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRMCaseLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_m__case_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rm_case_id')->nullable();
            $table->integer('case_status_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('sender_user_id')->nullable();
            $table->integer('receiver_user_id')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_m__case_logs');
    }
}
