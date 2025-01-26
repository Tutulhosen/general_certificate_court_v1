<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRMCaseRgistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_m__case_rgisters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('case_no')->nullable();
            $table->date('case_date')->nullable();
            $table->tinyInteger('action_user_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('division_id')->nullable();
            $table->string('arji_file')->nullable();
            $table->tinyInteger('result')->nullable();
            $table->string('result_file')->nullable();
            $table->text('case_reason')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('comments')->nullable();
            $table->tinyInteger('in_favour_govt')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('govt_lost_reason')->nullable();
            $table->tinyInteger('is_appeal')->nullable();
            $table->integer('rm_case_ref_id')->nullable();
            $table->string('ref_rm_case_no')->nullable();
            $table->integer('case_type_id')->nullable();
            $table->integer('case_status_id')->nullable();
            $table->integer('mouja_id')->nullable();
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
        Schema::dropIfExists('r_m__case_rgisters');
    }
}
