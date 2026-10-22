<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    /**
     * التحقق من الصلاحية: المدرس صاحب الكورس حصراً هو من يحق له التعديل
     */
    public function authorize(): bool
    {
        $course = $this->route('course'); // جلب كائن الكورس من المسار
        $user   = $this->user();

        return $user && $course && (int) $course->user_id === (int) $user->id;
    }

    public function rules(): array
    {
        return [
            'title'       => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'level'       => ['sometimes', 'in:Beginner,Intermediate,Advanced'],
            'price'       => ['sometimes', 'numeric', 'min:0'],
            'status'      => ['sometimes', 'in:Draft,Published'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'       => 'عنوان الكورس',
            'description' => 'وصف الكورس',
            'level'       => 'مستوى الكورس',
            'price'       => 'سعر الكورس',
            'status'      => 'حالة الكورس',
        ];
    }
}
