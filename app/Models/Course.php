<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'qr_code',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
