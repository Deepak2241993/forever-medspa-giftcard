<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable=['fname', 'lname', 'city', 'country', 'zip_code', 'phone', 'address', 'email', 'status', 'user_token', 'created_at', 'updated_at','password','image'];
}
