<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * التحقق من الصلاحية: المدرسين فقط يمكنهم إنشاء كورس
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->role === 'instructor';
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'level'       => ['required', 'in:Beginner,Intermediate,Advanced'],
            'price'       => ['required', 'numeric', 'min:0'],
            'status'      => ['nullable', 'in:Draft,Published'],
        ];
    }

    /**
     * تعريب أسماء الحقول لرسائل الخطأ
     */
    public function attributes(): array
    {
        return [
            'title'       => 'عنوان الكورس',
            'description' => 'وصف الكورس',
            'level'       => 'مستوى الكورس',
            'price'       => 'سعر الكورس',
            'status'      => 'حالة الكورس',
        ];
    }

    /**
     * تخصيص الرسائل بالعربية
     */
    public function messages(): array
    {
        return [
            'required' => 'حقل :attribute مطلوب ولا يمكن تركه فارغاً.',
            'in'       => 'القيمة المختارة لـ :attribute غير صالحة.',
            'numeric'  => 'حقل :attribute يجب أن يكون رقماً.',
            'min'      => 'حقل :attribute لا يمكن أن يكون أقل من :min.',
        ];
    }
}
