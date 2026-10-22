<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Support\Facades\DB;

class CourseService
{
    /**
     * إنشاء كورس جديد مع التعامل مع المعاملات (Database Transactions)
     */
    public function store(array $data, int $userId): Course
    {
        return DB::transaction(function () use ($data, $userId) {
            $data['user_id'] = $userId;

            // إنشاء الكورس
            $course = Course::create($data);

            // إذا أُرسلت صورة غلاف مع الكورس، يتم حفظها عبر الـ Polymorphic Relation
            if (isset($data['image_url'])) {
                $course->image()->create([
                    'url' => $data['image_url']
                ]);
            }

            return $course;
        });
    }

    /**
     * تحديث الكورس
     */
    public function update(Course $course, array $data): Course
    {
        return DB::transaction(function () use ($course, $data) {
            $course->update($data);

            if (isset($data['image_url'])) {
                $course->image()->updateOrCreate(
                    ['imageable_type' => 'course', 'imageable_id' => $course->id],
                    ['url' => $data['image_url']]
                );
            }

            return $course;
        });
    }
}
