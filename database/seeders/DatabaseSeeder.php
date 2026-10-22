<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء التصنيفات الأساسية (لا تتكرر ومتاحة للجميع)
        $categories = collect(['Laravel', 'PHP', 'SQL', 'UI/UX Design'])->map(function ($name) {
            return Category::create(['name' => $name]);
        });

        // 2. إنشاء مدرس
        $instructor = User::create([
            'name'     => 'المهندس أحمد',
            'email'    => 'instructor@towsila.test',
            'password' => Hash::make('password'),
            'role'     => 'instructor',
        ]);

        // 3. إنشاء طالب
        $student = User::create([
            'name'     => 'علي عباس',
            'email'    => 'student@towsila.test',
            'password' => Hash::make('password'),
            'role'     => 'student',
        ]);

        // 4. إنشاء كورس للمدرس
        $course = Course::create([
            'user_id'     => $instructor->id,
            'title'       => 'احتراف إطار العمل Laravel من الصفر حتى الاحتراف',
            'description' => 'كورس متقدم يشمل معمارية الـ API والعلاقات البوليمورفية.',
            'level'       => 'Advanced',
            'price'       => 150.00,
            'status'      => 'Published',
        ]);

        // ربط الكورس بالتصنيفات عبر الـ Polymorphic Many-to-Many
        $course->categories()->attach($categories->random(2)->pluck('id'));

        // إضافة صورة غلاف للكورس عبر الـ Polymorphic One-to-One
        $course->image()->create([
            'url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c',
        ]);

        // تسسجيل الطالب في الكورس
        $student->enrolledCourses()->attach($course->id);

        // 5. إنشاء درس تابع للكورس
        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title'     => 'مقدمة في المعمارية النظيفة',
            'video_url' => 'https://www.youtube.com/watch?v=example',
            'content'   => 'شرح تفصيلي حول فصل الاهتمامات.',
        ]);

        // إضافة تعليق للطالب على الدرس عبر الـ Polymorphic One-to-Many
        Comment::create([
            'user_id'          => $student->id,
            'commentable_type' => 'lesson',
            'commentable_id'   => $lesson->id,
            'body'             => 'شرح رائع جداً، شكراً لك يا مهندس.',
        ]);
    }
}
