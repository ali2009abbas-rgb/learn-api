<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * إضافة تعليق جديد (على كورس، درس، أو واجب) بطريقة بوليمورفية
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;

        // خريطة الـ Morph Map القصيرة التي عرفناها في AppServiceProvider
        $morphMap = [
            'course'     => \App\Models\Course::class,
            'lesson'     => \App\Models\Lesson::class,
            'assignment' => \App\Models\Assignment::class,
        ];

        // تحويل نوع المحتوى النصي إلى كلاس الموديل الفعلي عبر الـ Morph Map
        $targetModelClass = $morphMap[$validatedData['commentable_type']] ?? null;

        if (!$targetModelClass || !class_exists($targetModelClass)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'نوع المحتوى المستهدف غير صالح.',
            ], 422);
        }

        $targetItem = $targetModelClass::find($validatedData['commentable_id']);

        if (!$targetItem) {
            return response()->json([
                'status'  => 'error',
                'message' => 'المحتوى المراد التعليق عليه غير موجود.',
            ], 404);
        }

        // إنشاء التعليق باستخدام علاقة البوليمورفيك المباشرة
        $comment = $targetItem->comments()->create([
            'user_id' => $validatedData['user_id'],
            'body'    => $validatedData['body'],
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم إضافة التعليق بنجاح',
            'data'    => $comment->load('user:id,name'),
        ], 201);
    }
}
