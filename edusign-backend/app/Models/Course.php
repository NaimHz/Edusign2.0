<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'promotion_id',
    ];

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'course_student')
            ->withPivot('status')
            ->withTimestamps();
    }
}
