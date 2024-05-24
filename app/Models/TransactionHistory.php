<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable=['user_id', 'transaction_id', 'amount', 'status', 'created_at', 'updated_at', 'card_type', 'last_for_digit'];
}
