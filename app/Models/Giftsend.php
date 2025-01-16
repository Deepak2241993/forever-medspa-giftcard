<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giftsend extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable=['future_mail_status', 'qty', 'amount', 'your_name', 'recipient_name', 'message', 'gift_card_send_type', 'in_future', 'status', 'coupon_code', 'gift_send_to', 'user_token', 'created_at', 'updated_at', 'receipt_email', 'discount', 'transaction_id', 'payment_status', 'payment_time', 'transaction_amount', 'giftcards_number', 'payment_mode', 'event_id'];
}
