<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CateFooterFormRequest extends FormRequest
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
            $checkNameUpdate = DB::table('cate_footer')->select('id')
            ->where('name', '=', $params['name'])
            ->where('id', '=', $params['id'])
            ->value('id');
        }
        if (!empty($params['id']) && ($params['id'] == $checkNameUpdate)) {
            $ruleUpdateName = "required";
        }

        return [
            'name' => (isset($ruleUpdateName)) ? $ruleUpdateName : 'required | unique:cate_footer',
            'stt_menu' => (!empty($params['stt_menu'])) ? 'integer|min:0' : ''
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục footer không được bỏ trống.',
            'name.unique' => 'Tên danh mục footer đã tồn tại. Vui lòng thay đổi tên khác.',
            'stt_menu.integer' => 'Số thứ tự phải là số nguyên.',
            'stt_menu.min' => 'Số thứ tự phải lớn 0',
        ];
    }
}