<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'commentable_type',
        'commentable_id',
        'body',
    ];

    /**
     * علاقة بوليمورفيك عكسية (التعليق ينتمي لأي كيان: كورس، درس، واجب)
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * صاحب التعليق (مدرس أو طالب)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
