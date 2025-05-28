<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'session_id',
        'check_in',
    ];

    protected $casts = [
        'check_in' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
