<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SliderFormRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'url' => 'required',
            'url_text' => 'required',
            'filepath' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên Slider không được để trống',
            'title.required' => 'Tiêu đề không được để trống',
            'description.required' => 'Mô tả không được để trống',
            'url.required' => 'Url không được để trống',
            'url_text.required' => 'Tên Url không được để trống',
            'filepath.required' => 'Image không được để trống',
        ];
    }
}
