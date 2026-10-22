<?php

namespace App\Models;

use App\Traits\Commentable;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Commentable, HasImages;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // instructor, student
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * الكورسات التي ينشئها المستخدم (إذا كان مدرساً)
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'user_id');
    }

    /**
     * الكورسات التي سجل فيها الطالب
     */
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'user_id', 'course_id')
                    ->withTimestamps();
    }
}
