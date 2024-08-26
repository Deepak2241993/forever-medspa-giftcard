<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_redeem extends Model
{
    use HasFactory;
    protected $fillable=['order_id', 'service_id', 'number_of_session_use', 'status', 'created_at', 'updated_at', 'is_deleted', 'updated_by', 'user_token', 'transaction_id', 'comments'];
}
