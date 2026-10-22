<?php

namespace App\Models;

use App\Traits\Commentable;
use App\Traits\HasCategories;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    use HasFactory, Commentable, HasImages, HasCategories;

    protected $fillable = [
        'course_id',
        'title',
        'description',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
