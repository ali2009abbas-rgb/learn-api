<?php

namespace App\Providers;

use App\Contracts\FileUploaderInterface;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Services\LocalFileUploader;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FileUploaderInterface::class, LocalFileUploader::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       // ربط الأسماء القصيرة بالكلاسات الفعلية لتجنب مشاكل تغيير المسارات مستقبلاً
        Relation::morphMap([
            'course'     => Course::class,
            'lesson'     => Lesson::class,
            'assignment' => Assignment::class,
            'user'       => User::class, // للمدربين والطلاب
        ]);
    }
}
