<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'student_id',
        'qr_code',
        'promotion_id',
    ];

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_student')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class, 'session_student')
            ->withPivot('status')
            ->withTimestamps();
    }
}
