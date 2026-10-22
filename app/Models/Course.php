<?php

namespace App\Models;

use App\Traits\Commentable;
use App\Traits\HasCategories;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory, Commentable, HasImages, HasCategories;

    protected $fillable = [
        'title',
        'description',
        'level', // Beginner, Intermediate, Advanced
        'status', // Draft, Published
        'price',
        'user_id', // المدرس صاحب الكورس
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // ==========================================
    // Local Scopes (لتجنب تكرار الشروط البرمجية)
    // ==========================================

    /**
     * نطاق لجلب الكورسات المنشورة فقط (للطلاب)
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    /**
     * نطاق لتصفية الكورسات حسب المستوى
     */
    public function scopeLevel(Builder $query, string $level): Builder
    {
        return $query->where('level', $level);
    }

    // ==========================================
    // العلاقات (Eloquent Relationships)
    // ==========================================

    /**
     * الكورس ينتمي إلى مدرس (مستخدم)
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * الكورس يمتلك عدة دروس
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * الكورس مسجل فيه عدة طلاب (علاقة Many-to-Many عبر جدول enrollments)
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id')
                    ->withTimestamps();
    }
}
