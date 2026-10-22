<?php

namespace App\Services;

use App\Contracts\FileUploaderInterface;

class LocalFileUploader implements FileUploaderInterface
{
    public function upload($file): string
    {
        // منطق التخزين المحلي (مثلاً عبر disk)
        return $file->store('uploads', 'public');
    }
}
