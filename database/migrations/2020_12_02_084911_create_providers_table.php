<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique()->nullable();
            // $table->string('phone_no')->nullable();
            $table->string('company_name')->nullable();
            $table->string('service')->nullable();
            $table->string('experience')->nullable();
            $table->string('rate')->nullable();
            $table->date('working_start')->nullable();
            $table->date('working_end')->nullable();
            $table->string('work_start_time')->nullable();
            $table->string('work_end_time')->nullable();
            $table->string('avg_rating')->nullable();
            $table->string('company_description')->nullable();
            // $table->string('job_status')->nullable();
            $table->text('done_jobs_images')->nullable();
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
        Schema::dropIfExists('providers');
    }
}
