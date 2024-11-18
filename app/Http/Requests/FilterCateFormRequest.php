<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FilterCateFormRequest extends FormRequest
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

        $ruleUpdateName = 'required';
        $ruleUpdateSlug = 'required | max:255 | regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/ | unique:filter_cate';
        
        if (!empty($params['id'])) {
            // Kiểm tra tên đã tồn tại khi cập nhật
            $checkNameUpdate = DB::table('filter_cate')
                ->select('id')
                ->where('name', '=', $params['name'])
                ->where('id', '!=', $params['id'])
                ->value('id');
        
            if ($checkNameUpdate) {
                $ruleUpdateName = 'required';
            }
        
            // Kiểm tra slug đã tồn tại khi cập nhật
            // Sử dụng unique với ngoại lệ cho bản ghi có id hiện tại
            $ruleUpdateSlug = 'required|max:255|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|unique:filter_cate,slug,' . $params['id'];
        }

        return [
            'name' => $ruleUpdateName,
            'slug' => $ruleUpdateSlug,
            'cate_id' => 'required',
            'stt_filter' => !empty($params['stt_filter']) ? 'integer|min:0' : '',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên bộ lọc không được bỏ trống.',
            'name.unique' => 'Tên bộ lọc đã tồn tại. Vui lòng thay đổi tên khác.',
            'slug.required' => 'Url không được bỏ trống.',
            'slug.unique' => 'URL đã tồn tại. Vui lòng thay đổi url khác.',
            'slug.max' => 'Url không được vượt quá 255 ký tự.',
            'slug.regex' => 'Url chỉ được phép chứa chữ cái thường, số và dấu gạch ngang.',
            'cate_id.required' => 'Danh mục sản phẩm không được bỏ trống.',
            'stt_filter.integer' => 'Số thứ tự phải là số nguyên.',
            'stt_filter.min' => 'Số thứ tự phải lớn 0',
        ];
    }
}