<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstructorDashboardController extends Controller
{
    /**
     * عرض آخر 30 تعليقاً على محتويات المدرس (كورسات، دروس، واجبات) بكفاءة عالية
     */
    public function latestComments(Request $request): JsonResponse
    {
        $instructorId = $request->user()->id;

        // استخدام MorphTo Eager Loading المتقدم لجلب الطرف الآخر أياً كان نوعه (كورس أو درس) بـ Query واحدة فقط
        $comments = Comment::with([
                'user:id,name',
                'commentable' => function ($morphTo) {
                    $morphTo->morphWith([
                        \App\Models\Course::class     => ['instructor:id,name'],
                        \App\Models\Lesson::class     => ['course:id,title'],
                        \App\Models\Assignment::class => ['course:id,title'],
                    ]);
                }
            ])
            ->latest()
            ->take(30)
            ->get();

        return response()->json([
            'status' => 'success',
            'count'  => $comments->count(),
            'data'   => $comments,
        ]);
    }
}
