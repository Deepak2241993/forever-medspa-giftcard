<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable=['program_name', 'description', 'selling_price', 'terms_and_conditions', 'status', 'created_at', 'updated_at', 'unit_id', 'is_deleted'];

}
