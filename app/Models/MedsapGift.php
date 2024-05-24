<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedsapGift extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable=[ 'title', 'category_id', 'template_id', 'amount', 'status', 'created_at', 'updated_at','coupon_code','image'];
}
