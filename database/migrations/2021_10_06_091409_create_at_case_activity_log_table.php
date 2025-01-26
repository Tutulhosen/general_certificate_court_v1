<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtCaseActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('at_case_activity_log', function (Blueprint $table) {
            $table->increments('id');
            $table->json('user_info')->nullable()->comment("user_info,ip address and user_agent");
            $table->integer('at_case_id')->nullable();
            $table->enum('activity_type', ['create', 'update', 'delete', 'view', 'generate', 'archive'])->nullable();
            $table->string('massage')->nullable();
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->integer('column_8');
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
        Schema::dropIfExists('at_case_activity_log');
    }
}
