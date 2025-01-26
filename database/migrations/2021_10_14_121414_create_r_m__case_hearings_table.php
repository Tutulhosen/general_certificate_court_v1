<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRMCaseHearingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_m__case_hearings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rm_case_id')->nullable();
            $table->date('hearing_date')->nullable();
            $table->string('hearing_file')->nullable();
            $table->text('comments')->nullable();
            $table->string('hearing_result_file')->nullable();
            $table->text('hearing_result_comments')->nullable();
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
        Schema::dropIfExists('r_m__case_hearings');
    }
}
