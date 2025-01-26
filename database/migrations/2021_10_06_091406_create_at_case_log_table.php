<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtCaseLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('at_case_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('at_case_id')->nullable();
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
        Schema::dropIfExists('at_case_log');
    }
}
