<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * التصنيف الواحد يتبع لعشرات الكورسات (عبر morphToMany)
     */
    public function courses(): MorphToMany
    {
        return $this->morphedByMany(Course::class, 'categoryable');
    }

    /**
     * التصنيف الواحد يتبع لعشرات الدروس
     */
    public function lessons(): MorphToMany
    {
        return $this->morphedByMany(Lesson::class, 'categoryable');
    }
}
