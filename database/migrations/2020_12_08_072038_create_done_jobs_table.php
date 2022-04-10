<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoneJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('done_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('consumer_id')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('job_title')->nullable();
            $table->string('job_description')->nullable();
            $table->text('job_location')->nullable();
            $table->enum('job_status',['accepted','not_accepted'])->default('not_accepted')->nullable();
            $table->enum('job_done_status',['done','pending'])->default(null)->nullable();
            $table->string('job_date')->nullable();
            $table->string('job_time')->nullable();
            $table->string('images')->nullable();
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
        Schema::dropIfExists('done_jobs');
    }
}
