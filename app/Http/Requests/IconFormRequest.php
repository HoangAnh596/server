<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IconFormRequest extends FormRequest
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
            'name' => 'required',
            'url' => 'required',
            'icon' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name không được để trống',
            'url.required' => 'Địa chỉ đường dẫn không được để trống',
            'icon.required' => 'Icon không được để trống',
        ];
    }
}
