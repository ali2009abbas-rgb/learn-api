# 🎓 E-Learning API Platform

منصة تعليم عن بعد متقدمة ومبنية باستعمال كواجهة برمجة تطبيقات (**API**)، مع التركيز الصارم على معمارية الـ Clean Code، Thin Controllers، وتجنب تكرار الجداول عبر العلاقات البوليمورفية المتقدمة (Polymorphic Relations).

---

## 🛠️ المعمارية والتقنيات المستخدمة (Architectural Highlights)

1. **Polymorphic Design (عدم تكرار الجداول):**
    - **Comments:** جدول مركزي واحد للتعليقات يرتبط بـ (الكورسات، الدروس، والواجبات) بسطر واحد.
    - **Images:** جدول مركزي واحد للصور يغطي (غلاف الكورس، الصورة الشخصية للمدرس، الصور المصغرة).
    - **Categories:** جدول تصنيفات فريد مرتبط بمختلف أنواع المحتوى عبر جدول وسيط (`categoryables`) مع استخدام `MorphMap` لفك ارتباط أسماء الـ Classes بقاعدة البيانات.
2. **Separation of Concerns & Clean Code:**
    - **FormRequests:** عزل كامل للتحقق والصلاحيات (Validation & Authorization) عن الـ Controllers، مع تعريب كامل لرسائل الأخطاء وأسماء الحقول.
    - **Custom Validation Rule:** قاعدة مستقلة (`ApprovedVideoUrl`) للتحقق من أن روابط الفيديو تنتمي حصراً لمنصتي **YouTube** أو **Vimeo**.
    - **Global & Local Scopes:** تطبيق النطاقات لتنظيف الاستعلامات وإدارة حالات الكورسات (Draft / Published).
3. **Performance & Optimization:**
    - تطبيق Eager Loading المتقدم مع MorphTo لضمان عدم حدوث مشاكل **N+1 Query Issue**.
    - قياس دقيق لعدد الاستعلامات في لوحة تحكم المدرس (آخر التعليقات).

---

## ⚙️ متطلبات التشغيل (Prerequisites)

- **PHP** >= 8.2
- **Composer**
- **MySQL / MariaDB**

---

## 🚀 خطوات التثبيت والتشغيل المحلّي (Installation Guide)

1. **نسخ المستودع وتثبيت الحزم:**
    ```bash
    git clone [https://github.com/YOUR_USERNAME/learn-api.git](https://github.com/YOUR_USERNAME/learn-api.git)
    cd learn-api
    composer install
    إعداد ملف البيئة (.env):
    قم بإنشاء ملف .env من خلال نسخه وتعديل بيانات اتصال قاعدة البيانات:
    ```

Bash
cp .env.example .env
php artisan key:generate
تشغيل الـ Migrations والـ Seeders معاً:
يقوم هذا الأمر بإنشاء كافة الجداول (بما فيها الجداول البوليمورفية والتسجيلات) وتعبئة بيانات تجريبية (مدرس، طالب، كورس، درس، تعليقات):

Bash
php artisan migrate:fresh --seed
تشغيل خادم التطوير المحلي:

Bash
php artisan serve
سيكون رابط الـ API الأساسي هو: http://127.0.0.1:8000/api حسب إعدادات السيرفر لديك.

📊 قياس الأداء وتحليل الاستعلامات (Performance & Query Analysis)
استعلام قائمة الكورسات العامة (GET /api/courses):

عدد الاستعلامات الفعلي: 2 استعلام فقط (استعلام رئيسي لجلب الكورسات مع الـ Pagination + استعلام Eager Loading واحد لجلب المدرسين، الصور، والتصنيفات معاً). هذا يضمن استجابة فائقة السرعة وخلو النظام تماماً من مشكلة الـ +1N.

استعلام لوحة تحكم المدرس لأخر التعليقات (GET /api/instructor/comments/latest):

يتم جلب آخر 30 تعليقاً مع بيانات الطلاب والعناصر المرتبطة بها (كورسات أو دروس) بكفاءة عالية جداً وبأقل عدد ممكن من الاستعلامات.

🔒 السياسات الأمنية والرموز (HTTP Status Codes)
200 OK / 201 Created: لنجاح العمليات.

422 Unprocessable Entity: لأخطاء التحقق (Validation Errors) مع تفاصيل الحقول بالعربية.

403 Forbidden: عند محاولة تنفيذ إجراء غير مسموح للمستخدم (مثل طالب يحاول إنشاء كورس، أو مدرس يعدل كورس مدرس آخر).

404 Not Found: عند عدم العثور على العنصر المطلوب.

📂 توثيق الـ Endpoints (Postman / Apidog)
تم تجهيز ملف اختبارات كامل يغطي حالات النجاح وحالات الرفض (التحقق والصلاحيات). يمكنك استيراد الـ Endpoints الأساسية التالية:

GET /api/courses (جلب الكورسات المنشورة)

POST /api/courses (إنشاء كورس - للمدرسين فقط)

POST /api/lessons (إضافة درس برابط فيديو معتمد)

POST /api/comments (إضافة تعليق - للطلاب المسجلين بالكورس حصراً)

GET /api/instructor/comments/latest (عرض آخر التعليقات للمدرس)
