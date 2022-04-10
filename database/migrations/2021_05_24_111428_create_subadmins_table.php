<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubadminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subadmins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('tmp_password')->nullable();
            $table->string('add_permission')->nullable();
            $table->string('edit_permission')->nullable();
            $table->string('delete_permission')->nullable();
            $table->string('add_category_permission')->nullable();
            $table->string('edit_category_permission')->nullable();
            $table->string('delete_category_permission')->nullable();
            $table->string('add_consumer_permission')->nullable();
            $table->string('edit_consumer_permission')->nullable();
            $table->string('add_provider_permission')->nullable();
            $table->string('edit_provider_permission')->nullable();
            $table->string('add_job_permission')->nullable();
            $table->string('edit_job_permission')->nullable();
            $table->string('image')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('subadmins');
    }
}
