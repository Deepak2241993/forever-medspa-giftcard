<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable=['order_id', 'fname', 'lname', 'city', 'country', 'zip_code', 'phone', 'address', 'email', 'transaction_id', 'sub_amount','tax_amount', 'final_amount', 'status', 'card_type', 'last_for_digit', 'gift_card_applyed', 'gift_card_amount', 'payment_status', 'transaction_status', 'payment_intent', 'created_at', 'updated_at','transaction_amount','payment_session_id'];
}
