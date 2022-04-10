<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('consumer_id')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('job_title')->nullable();
            $table->string('job_category')->nullable();
            $table->text('job_description')->nullable();
            $table->string('job_location')->nullable();
            $table->string('job_lat')->nullable();
            $table->string('job_long')->nullable();
            $table->enum('job_status',['accepted','not_accepted','rejected'])->default('not_accepted')->nullable();
            $table->enum('work_mode',['contract','hourly'])->default(null)->nullable();
            $table->string('hours')->nullable();
            $table->string('amount')->nullabe();
            $table->text('work_description')->nullable();
            $table->enum('job_cancel_status',['0','1'])->default('0')->nullable();
            $table->enum('job_done_status',['done','pending'])->default('pending')->nullable();
            $table->enum('payment_status',['done','pending'])->default('pending');
            $table->string('job_date')->nullable();
            $table->string('job_time')->nullable();
            $table->text('images')->nullable();
            $table->text('completed_job_images')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
