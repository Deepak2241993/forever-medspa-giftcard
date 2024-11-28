<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;
    protected $fillable=['order_id', 'service_id', 'service_type', 'qty', 'number_of_session', 'status', 'user_token', 'actual_amount', 'discounted_amount', 'payment_mode', 'is_deleted', 'updated_by', 'updated_at', 'created_at'];
}
