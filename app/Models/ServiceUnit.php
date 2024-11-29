<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceUnit extends Model
{
    use HasFactory;

    protected $fillable=['product_name', 'product_slug', 'short_description', 'product_description', 'product_image', 'user_token', 'min_qty', 'max_qty', 'amount', 'discounted_amount', 'giftcard_redemption', 'status', 'product_is_deleted', 'created_at', 'updated_at', 'meta_title', 'meta_description', 'meta_keywords', 'cat_id', 'coupon_id', 'search_keywords', 'prerequisites', 'popular_service', 'session_number', 'discount_rate'];
}
