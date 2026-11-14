<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'user_id' => 'required|unique:profiles,user_id|exists:users,id',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'bio' => 'nullable|string',
            'image' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048',
        ];
    }
    // احذف حقل user_id من مصفوفة الـ rules نهائياً، واجلب معرف المستخدم بأمان داخل الكنترولر مباشرة من الـ Authentication المتوفر في السيرفر كالتالي:
    // داخل الكنترولر في دالة التحديث أو الإنشاء
    // $userId = auth()->id(); // أو $request->user()->id;

}
