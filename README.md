# منصة التعليم عن بعد (E-Learning API) - التاسك الخامس

## 🚀 نبذة عن المشروع

منصة تعليمية متقدمة مبنية بـ Laravel 11، تعتمد بالكامل على معمارية الـ Polymorphic Relations لتوحيد جداول (التعليقات، الصور، والتصنيفات) وتجنب تكرار الكود (DRY)، مع تطبيق مبادئ الـ Clean Code و Thin Controllers.

## ⚙️ طريقة التشغيل

1. قم بنسخ المستودع وتثبيت الحزم:
    ```bash
    composer install
    انسخ ملف البيئة وأنشئ مفتاح التطبيق:
    ```

Bash
cp .env.example .env
php artisan key:generate
شغل الـ Migrations مع الـ Seeders معاً:

Bash
php artisan migrate:fresh --seed
شغل خادم التطوير:

Bash
php artisan serve
📊 قياس الأداء (عدد الاستعلامات)
استعلام قائمة الكورسات (GET /api/courses): ينفذ 2 استعلام فقط بغض النظر عن عدد السجلات (استعلام لجلب الكورسات مع الـ Pagination واستعلام للعلاقات Eager Loading)، مما يمنع مشكلة الـ N+1 تماماً.
