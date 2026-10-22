<?php

namespace App\Models;

use App\Traits\Commentable;
use App\Traits\HasCategories;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory, Commentable, HasImages, HasCategories;

    protected $fillable = [
        'course_id',
        'title',
        'video_url',
        'content',
    ];

    /**
     * الدرس ينتمي إلى كورس واحد
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
