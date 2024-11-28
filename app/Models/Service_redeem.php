<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_redeem extends Model
{
    use HasFactory;
    protected $fillable=['order_id', 'product_id', 'service_type', 'service_order_id', 'number_of_session_use', 'transaction_id', 'refund_amount', 'user_token', 'comments', 'is_deleted', 'updated_by', 'status', 'created_at', 'updated_at'];
}
