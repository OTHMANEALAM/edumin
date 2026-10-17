<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'specialties',
    ];

    // تحويل حقل التخصصات تلقائياً من وإلى مصفوفة (Array)
    protected $casts = [
        'specialties' => 'array',
    ];
}
