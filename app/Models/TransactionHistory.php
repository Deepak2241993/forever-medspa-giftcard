<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable=[ 'order_id', 'fname', 'lname', 'city', 'country', 'zip_code', 'phone', 'address', 'email', 'transaction_id', 'sub_amount', 'tax_amount', 'final_amount', 'transaction_amount', 'payment_session_id', 'status', 'card_type', 'last_for_digit', 'gift_card_applyed', 'gift_card_amount', 'payment_status', 'transaction_status', 'payment_intent', 'created_at', 'updated_at', 'user_token','payment_mode'];

    // In TransactionHistory.php
public function orderItems()
{
    return $this->hasMany(ServiceOrder::class, 'order_id', 'order_id');
}

// In ServiceOrder.php
public function product()
{
    return $this->belongsTo(Product::class, 'service_id');
}

}
