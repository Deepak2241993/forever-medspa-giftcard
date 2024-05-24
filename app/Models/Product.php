<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=['product_name', 'product_description', 'product_image', 'product_order_by', 'product_fetured', 'meta_title', 'meta_description', 'meta_keywords', 'product_is_deleted', 'user_token', 'status', 'cat_id', 'amount', 'coupon_id', 'discounted_amount', 'created_at', 'updated_at'];
}
