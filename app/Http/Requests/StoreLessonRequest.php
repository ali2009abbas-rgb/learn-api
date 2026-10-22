<?php

namespace App\Http\Requests;

use App\Models\Course;
use App\Rules\ApprovedVideoUrl;
use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
{
    /**
     * التحقق من الصلاحية: المدرس صاحب الكورس فقط
     */
    public function authorize(): bool
    {
        $courseId = $this->input('course_id');
        $course   = Course::find($courseId);
        $user     = $this->user();

        return $user && $course && (int) $course->user_id === (int) $user->id;
    }

    public function rules(): array
    {
        return [
            'course_id' => ['required', 'exists:courses,id'],
            'title'     => ['required', 'string', 'max:255'],
            'video_url' => ['required', new ApprovedVideoUrl()],
            'content'   => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'course_id' => 'الكورس',
            'title'     => 'عنوان الدرس',
            'video_url' => 'رابط فيديو الدرس',
            'content'   => 'محتوى الدرس',
        ];
    }
}
