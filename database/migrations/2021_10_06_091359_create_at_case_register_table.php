<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtCaseRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('at_case_register', function (Blueprint $table) {
            $table->increments('id');
            $table->string('case_no')->nullable();
            $table->date('case_date')->nullable();
            $table->tinyInteger('action_user_id')->nullable();
            $table->tinyInteger('court_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('division_id')->nullable();
            $table->string('notice_file')->nullable();
            $table->string('sf_scan1')->nullable();
            $table->string('sf_scan2')->nullable();
            $table->tinyInteger('result')->nullable();
            $table->string('result_file')->nullable();
            $table->text('case_reason')->nullable();
            $table->dateTime('sf_deadline')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('comments')->nullable();
            $table->tinyInteger('in_favour_govt')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('govt_lost_reason')->nullable();
            $table->integer('advocate_id')->nullable();
            $table->tinyInteger('is_appeal')->nullable();
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
        Schema::dropIfExists('at_case_register');
    }
}
