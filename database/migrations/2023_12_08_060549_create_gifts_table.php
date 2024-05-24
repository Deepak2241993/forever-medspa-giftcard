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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->string('from_name')->nullable();
            $table->string('to_name')->nullable();
            $table->string('to')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('from')->nullable();
            $table->string('msg')->nullable();
            $table->string('code',12)->unique()->nullable();
            $table->date('future_data')->nullable();
            $table->tinyInteger('is_redeemed')->default(0);
            $table->decimal('amount', 8, 2)->nullable()->default(0.00);
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
        Schema::dropIfExists('gifts');
    }
};
