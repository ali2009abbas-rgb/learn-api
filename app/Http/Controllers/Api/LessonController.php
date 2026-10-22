<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Models\Lesson;
use Illuminate\Http\JsonResponse;

class LessonController extends Controller
{
    /**
     * إنشاء درس جديد مرتبط بكورس معين
     */
    public function store(StoreLessonRequest $request): JsonResponse
    {
        $lesson = Lesson::create($request->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'تم إضافة الدرس بنجاح',
            'data'    => $lesson,
        ], 201);
    }
}
