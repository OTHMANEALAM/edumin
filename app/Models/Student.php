<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

 protected $fillable = [
        'registration_number',
        'course_id',
        'first_name',
        'last_name',
        'birth_date',
        'cin',
        'cin_document',
        'phone',
        'whatsapp',
        'received_by',
        'registered_by',
        'training_mode',
        'registration_date',
        'registration_fee_paid',
        'registration_payment_type', // جديد
        'payment_method',
        'group_name',
        'status',
        'is_welcomed',              // جديد
        'welcomed_at',   
        'next_payment_date',
        'admin_notes',    
        'is_quitted',
    'quit_reason',
    'quit_date',
    'training_mode',        // جديد
    ];

    protected $casts = [
        'welcomed_at' => 'datetime',
        'is_welcomed' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function payments()
    {
        
        return $this->hasMany(Payment::class);
    }
}