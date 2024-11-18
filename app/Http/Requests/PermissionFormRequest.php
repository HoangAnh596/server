<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PermissionFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        $params = $this->request->all();
        // Lấy ID của permission từ request (nếu có)
        $permissionId = $params['id'] ?? null;

        return [
            'name' => 'required|min:3|max:50',
            'display_name' => 'required|min:3|max:150',
            'key_code' => [
                'required',
                Rule::unique('permissions', 'key_code')->ignore($permissionId), // Bỏ qua chính id đang được cập nhật
                'regex:/^[a-zA-Z]+(_[a-zA-Z]+)*$/',
            ],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên Permission không được bỏ trống.',
            'name.min' => 'Tên Permission ít nhất 3 ký tự',
            'name.max' => 'Tên Permission không được vượt quá 50 ký tự.',
            'display_name.required' => 'Tên hiển thị Permission không được bỏ trống.',
            'display_name.min' => 'Tên hiển thị Permission ít nhất 3 ký tự',
            'display_name.max' => 'Tên hiển thị Permission không được vượt quá 150 ký tự.',
            'key_code.required' => 'Mã code không được bỏ trống.',
            'key_code.unique' => 'Mã code không được trùng lặp.',
            'key_code.regex' => 'Mã code phải là chữ và "_" ở giữa, không được chứa các ký tự.',
        ];
    }
}
