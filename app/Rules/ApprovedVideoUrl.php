<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ApprovedVideoUrl implements ValidationRule
{
    /**
     * التحقق من أن رابط الفيديو ينتمي حصراً لـ YouTube أو Vimeo
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail('يجب أن يكون :attribute رابطاً نصياً صحيحاً.');
            return;
        }

        // استخدام Regular Expressions للتحقق من النطاقات المعتمدة
        $youtubePattern = '/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/i';
        $vimeoPattern   = '/^(https?:\/\/)?(www\.)?vimeo\.com\/.+$/i';

        if (!preg_match($youtubePattern, $value) && !preg_match($vimeoPattern, $value)) {
            $fail('رابط :attribute غير معتمد. نتقبل فقط روابط فيديوهات منصتي YouTube و Vimeo.');
        }
    }
}
