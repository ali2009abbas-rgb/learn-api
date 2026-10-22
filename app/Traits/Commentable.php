<?php

namespace App\Traits;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Commentable
{
    /**
     * علاقة البوليمورفيك للتعليقات (أي موديل يستخدم هذه الـ Trait سيملك تعليقات تلقائياً)
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
