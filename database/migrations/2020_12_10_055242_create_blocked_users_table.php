<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocked_users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            
            $table->string('phone_no')->nullable();
            $table->string('device_token')->nullable();
            $table->enum('device_type', ['i', 'a'])->nullable();
            $table->enum('role', ['consumer', 'provider','admin'])->default('consumer')->nullable();
            
            $table->enum('is_blocked',[0,1])->default(0)->nullable();
            $table->enum('email_verified_at',[0,1])->default(0)->nullable();
            $table->string('password')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('account_number')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('blocked_users');
    }
}
