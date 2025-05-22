<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'student_id',
        'qr_code',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
