<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommentFormRequest extends FormRequest
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
            'name' => 'required | min:3 | max: 50',
            'content' => 'required | max:500 | min:3',
            'email' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên tối thiểu ít nhất 3 ký tự',
            'name.max' => 'Tên không được vượt quá 50 ký tự',
            'content.required' => 'Nội dung không được để trống',
            'content.min' => 'Nội dung tối thiểu ít nhất 3 ký tự',
            'content.max' => 'Nội dung không được vượt quá 500 ký tự',
            'email.required' => 'Email không được để trống',
        ];
    }
}
