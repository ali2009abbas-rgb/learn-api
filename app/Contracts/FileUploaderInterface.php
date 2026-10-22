<?php

namespace App\Contracts;

interface FileUploaderInterface
{
    public function upload($file): string;
}
