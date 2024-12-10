<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GroupsFormRequest extends FormRequest
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
            $checkNameUpdate = DB::table('groups')->select('id')
            ->where('name', '=', $params['name'])
            ->where('id', '=', $params['id'])
            ->value('id');
        }
        if (!empty($params['id']) && ($params['id'] == $checkNameUpdate)) {
            $ruleUpdateName = "required";
        }

        return [
            'name' => (isset($ruleUpdateName)) ? $ruleUpdateName : 'required | unique:groups',
            'cate_id' => 'required',
            'max_quantity' => (!empty($params['max_quantity'])) ? 'integer|min:0|max:99' : '',
            'stt' => (!empty($params['stt'])) ? 'integer|min:0' : ''
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên nhóm không được bỏ trống.',
            'name.unique' => 'Tên nhóm đã tồn tại. Vui lòng thay đổi tên khác.',
            'cate_id.required' => 'Danh mục sản phẩm không được bỏ trống.',
            'max_quantity.integer' => 'Số lượng phải là số nguyên.',
            'max_quantity.min' => 'Số lượng tối đa phải lớn hơn 0',
            'max_quantity.max' => 'Số lượng tối đa phải nhỏ hơn 99',
            'stt.integer' => 'Số thứ tự phải là số nguyên.',
            'stt.min' => 'Số thứ tự phải lớn 0',
        ];
    }
}