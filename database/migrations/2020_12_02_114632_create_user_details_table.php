<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique()->nullable();
            $table->enum('user_role',['admin','consumer','provider'])->nullable();
            $table->string('onboarding_status')->nullable();
            $table->string('stripe_account_id')->nullable();
            $table->string('stripe_refresh_token')->nullable();
            $table->text('feedback')->nullable();
            $table->text('description')->nullable();
            // $table->string('company_name')->nullable();
            // $table->string('service')->nullable();
            // $table->string('experience')->nullable();
            // $table->string('rate')->nullable();
            // $table->string('company_description')->nullable();
            $table->text('image')->nullable();
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
        Schema::dropIfExists('user_details');
    }
}
