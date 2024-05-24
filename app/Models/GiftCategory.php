<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCategory extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable=['name', 'status', 'created_at', 'updated_at'];
}
