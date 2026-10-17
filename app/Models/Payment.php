<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'month_name',
        'amount',
        'payment_method',
        'payment_date',
        'received_by',
        'notes',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}