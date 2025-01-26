<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('messages')->nullable();
            $table->integer('user_sender')->nullable();
            $table->integer('user_receiver')->nullable();
            $table->tinyInteger('receiver_seen')->default('0');
            $table->string('seen_at')->nullable();
            $table->tinyInteger('msg_reqest')->default('0');
            $table->tinyInteger('msg_remove')->default('0');
            $table->string('ip_info')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
