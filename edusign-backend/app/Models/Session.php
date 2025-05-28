<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
        'course_id',
        'qr_code',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($session) {
            $qrCode = QrCode::size(300)
                ->format('png')
                ->generate(route('admin.sessions.attendance', $session->id));

            $session->qr_code = 'data:image/png;base64,' . base64_encode($qrCode);
            $session->save();
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'session_student')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
