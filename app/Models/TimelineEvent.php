<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineEvent extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'patient_id', 'event_type', 'subject_type', 'subject_id', 'metadata', 'created_at', 'updated_at'];
}
