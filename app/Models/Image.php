<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'imageable_type',
        'imageable_id',
    ];

    /**
     * العلاقة البوليمورفيك العكسية للصورة
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
