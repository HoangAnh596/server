<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingFormRequest extends FormRequest
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
        return [
            'title_seo' => 'required',
            'keyword_seo' => 'required',
            'des_seo' => 'required',
            'mail_name' => 'required',
            'mail_pass' => 'required',
            'mail_text' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'title_seo.required' => 'Tiêu đề SEO không được để trống',
            'keyword_seo.required' => 'Từ khóa SEO không được để trống',
            'des_seo.required' => 'Mô tả SEO không được để trống',
            'mail_name.required' => 'Tiêu đề mail không được để trống',
            'mail_pass.required' => 'Mật khẩu mail không được để trống',
            'mail_text.required' => 'Email không được để trống',
        ];
    }
}
