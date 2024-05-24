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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable();
            $table->mediumText('product_description')->nullable();
            $table->string('product_image')->nullable();
            $table->string('product_order_by')->nullable();
            $table->string('product_fetured')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->tinyInteger('product_is_deleted')->default(0);
            $table->string('user_token')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('cat_id')->default(0);
            $table->decimal('amount', 8, 2)->nullable()->default(0.00);
            $table->integer('coupon_id')->nullable();
            $table->decimal('discounted_amount', 8, 2)->nullable()->default(0.00);
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
        Schema::dropIfExists('products');
    }
};
