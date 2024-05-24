<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giftsends', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('amount', 8, 2)->nullable()->default(0.00);
            $table->string('your_name')->nullable();
            $table->string('recipient_name')->nullable();
            $table->string('recipient_email')->nullable();
            $table->string('message')->nullable();
            $table->string('gift_card_send_type')->nullable();
            $table->string('in_future')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('coupon_code')->nullable();
            $table->string('gift_send_for')->nullable();
            $table->string('user_token')->nullable();
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
        Schema::dropIfExists('giftsends');
    }
};
