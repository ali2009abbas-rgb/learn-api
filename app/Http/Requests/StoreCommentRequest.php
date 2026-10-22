<?php

namespace App\Http\Requests;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * فحص الصلاحية: الطالب يجب أن يكون مسجلاً في الكورس ليعلق على دروسه أو الكورس نفسه
     */
    public function authorize(): bool
    {
        $user = $this->user();

        if (!$user) {
            return false;
        }

        // إذا كان مدرس، يسمح له بالتعليق دائماً
        if ($user->role === 'instructor') {
            return true;
        }

        $type = $this->input('commentable_type'); // course, lesson, assignment
        $id   = $this->input('commentable_id');

        $courseId = null;

        if ($type === 'course') {
            $courseId = $id;
        } elseif ($type === 'lesson') {
            $lesson   = Lesson::find($id);
            $courseId = $lesson?->course_id;
        }

        if (!$courseId) {
            return false;
        }

        // التأكد من وجود سجل للمستخدم في جدول التسجيلات (enrollments) لهذا الكورس
        return $user->enrolledCourses()->where('course_id', $courseId)->exists();
    }

    public function rules(): array
    {
        return [
            'commentable_type' => ['required', 'string', 'in:course,lesson,assignment'],
            'commentable_id'   => ['required', 'integer'],
            'body'             => ['required', 'string', 'min:3'],
        ];
    }

    public function attributes(): array
    {
        return [
            'commentable_type' => 'نوع المحتوى المعلق عليه',
            'commentable_id'   => 'معرف المحتوى',
            'body'             => 'نص التعليق',
        ];
    }
}
