<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class UserFormRequest extends FormRequest
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

        if (!empty($params['id'])) {
            $checkEmailUpdate = DB::table('users')->select('id')
                ->where('email', '=', $params['email'])
                ->where('id', '=', $params['id'])
                ->value('id');
        }
        
        if (!empty($params['id']) && ($params['id'] == $checkEmailUpdate)) {
            $ruleUpdateEmail = "required | email | max:255";
        } else {
            $ruleUpdateEmail = 'required | email | max:255 | unique:users';
        }

        // Kiểm tra tính duy nhất của slug trong cả hai bảng
        $uniqueSlugRule = function ($attribute, $value, $fail) use ($params) {
            $slugExistsInUser = DB::table('users')
                ->where('slug', $value)
                ->where('id', '!=', $params['id'] ?? 0)
                ->exists();

            if ($slugExistsInUser) {
                $fail('URL đã tồn tại. Vui lòng thay đổi url khác.');
            }
        };

        // Đặt điều kiện cho slug
        $slugRule = function () use ($params, $uniqueSlugRule) {
            if (isset($params['slug']) && !empty($params['slug'])) {
                return [
                    'string', 'max:255', 
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', // Điều kiện regex kiểm tra định dạng slug
                    $uniqueSlugRule
                ];
            } else {
                return ['nullable']; // Nếu slug null, cho phép bỏ qua việc kiểm tra.
            }
        };
        
        return [
            'name' => 'required|string|max:255',
            'email' => $ruleUpdateEmail,
            'slug' => $slugRule,
            'password' => 'nullable|string|min:8|confirmed',
            'filepath' => 'nullable|string',
            'content' => 'nullable|string',
            'title_img' => 'required|string',
            'alt_img' => 'required|string',
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'instagram' => 'nullable|string',
            'skype' => 'nullable|string',
            'linkedin' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên tài khoản không được để trống',
            'name.max' => 'Tên tài khoản không được vượt quá 255 ký tự',
            'slug.required' => 'Url tài khoản không được để trống',
            'slug.max' => 'Url tài khoản không được vượt quá 255 ký tự',
            'slug.regex' => 'Url chỉ được phép chứa chữ cái thường, số và dấu gạch ngang.',
            'slug.in' => 'Không được thay đổi slug',
            'email.required' => 'Email tài khoản không được để trống',
            'email.unique' => 'Email tài khoản đã tồn tại',
            'password.required' => 'Mật khẩu tài khoản không được để trống',
            'password.min' => 'Mật khẩu tài khoản tối thiểu nhất 8 ký tự',
            'password.confirmed' => 'Mật khẩu xác nhận không trùng',
            'title_img.required' => 'Thẻ title ảnh không được để trống',
            'alt_img.required' => 'Thẻ alt ảnh không được để trống',
        ];
    }
}
