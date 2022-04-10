<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumerCardDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumer_card_details', function (Blueprint $table) {
            $table->id();
            $table->string('consumer_id')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('card_expiry_month')->nullable();
            $table->string('card_expiry_year')->nullable();
            $table->string('card_type')->nullable();
            $table->string('bank_name')->nullable()->comment('Card issued by');
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
        Schema::dropIfExists('consumer_card_details');
    }
}
