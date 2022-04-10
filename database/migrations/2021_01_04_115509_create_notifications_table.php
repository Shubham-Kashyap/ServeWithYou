<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string("job_id")->nullable();
            $table->string("consumer_id")->nullable();
            $table->string("provider_id")->nullable();
            // $table->string('from')->nullablle();
            // $table->string('to')->nullable();
            $table->string("title")->nullable();
            $table->string("msg_title")->nullable();
            $table->string("description")->nullable();
            // $table->string("image")->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
