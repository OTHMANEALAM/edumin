<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mode',
        'duration_months',
        'academic_year',
        'start_date',
        'registration_fee',
        'monthly_fee',
    ];

    // علاقة التخصص بطلابه
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // علاقة التخصص بالشواهد الصادرة عنه
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}