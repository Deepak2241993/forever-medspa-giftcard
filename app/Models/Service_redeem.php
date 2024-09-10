<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_redeem extends Model
{
    use HasFactory;
    protected $fillable=[ 'order_id', 'service_id', 'number_of_session_use', 'created_at', 'transaction_id', 'updated_at', 'user_token', 'comments', 'is_deleted', 'updated_by', 'status','refund_amount'];
}
