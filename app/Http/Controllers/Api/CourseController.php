<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    protected CourseService $courseService;

    // حقن الخدمة عبر الـ Constructor
    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * عرض قائمة الكورسات المنشورة مع تجنب مشكلة N+1
     */
    public function index(): JsonResponse
    {
        $courses = Course::published()
            ->with(['instructor:id,name', 'image', 'categories'])
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data'   => $courses,
        ]);
    }

    /**
     * إنشاء كورس جديد
     */
    public function store(StoreCourseRequest $request): JsonResponse
    {
        $course = $this->courseService->store($request->validated(), $request->user()->id);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم إنشاء الكورس بنجاح',
            'data'    => $course->load(['instructor', 'image']),
        ], 201);
    }

    /**
     * تعديل الكورس
     */
    public function update(UpdateCourseRequest $request, Course $course): JsonResponse
    {
        $updatedCourse = $this->courseService->update($course, $request->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'تم تحديث الكورس بنجاح',
            'data'    => $updatedCourse,
        ]);
    }
}
