<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryNewFormRequest extends FormRequest
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

        // Kiểm tra nếu 'name' là "blogs"
        if (strtolower(trim($params['name'])) === 'blogs') {
            $ruleUpdateName = "required|not_in:blogs";
        } else {
            if (!empty($params['id'])) {
                $checkNameUpdate = DB::table('category_news')->select('id')
                    ->where('name', '=', $params['name'])
                    ->where('id', '=', $params['id'])
                    ->value('id');
            }

            if (!empty($params['id']) && ($params['id'] == $checkNameUpdate)) {
                $ruleUpdateName = "required";
            } else {
                $ruleUpdateName = 'required|unique:category_news';
            }
        }

        // Kiểm tra tính duy nhất của slug trong cả hai bảng và không được trùng "blogs"
        $uniqueSlugRule = function ($attribute, $value, $fail) use ($params) {
            if (strtolower(trim($value)) === 'blogs') {
                $fail('URL đã tồn tại. Vui lòng thay đổi url khác.');
            }

            $slugExistsInCategory = DB::table('category_news')
                ->where('slug', $value)
                ->where('id', '!=', $params['id'] ?? 0)
                ->exists();

            $slugExistsInNews = DB::table('news')
                ->where('slug', $value)
                ->exists();

            if ($slugExistsInCategory || $slugExistsInNews) {
                $fail('URL đã tồn tại. Vui lòng thay đổi url khác.');
            }
        };

        // Đặt điều kiện cho slug
        $slugRule = !empty($params['id'])
            ? ['in:' . DB::table('category_news')->where('id', $params['id'])->value('slug'), $uniqueSlugRule]
            : ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $uniqueSlugRule];

        return [
            'name' => $ruleUpdateName,
            'slug' => $slugRule,
            'stt_new' => (!empty($params['stt_new'])) ? 'integer|min:0' : '',
            'related_pro' => 'nullable|array',
            'related_pro.*' => 'integer',
            'title_seo' => 'required',
            'keyword_seo' => 'required',
            'des_seo' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục không được bỏ trống.',
            'name.unique' => 'Tên danh mục đã tồn tại. Vui lòng thay đổi tên khác',
            'name.not_in' => 'Tên danh mục đã tồn tại. Vui lòng thay đổi tên khác',
            'slug.required' => 'Url không được bỏ trống.',
            'slug.unique' => 'URL đã tồn tại. Vui lòng thay đổi url khác.',
            'slug.regex' => 'Url chỉ được phép chứa chữ cái thường, số và dấu gạch ngang.',
            'slug.in' => 'Không được thay đổi slug',
            // 'content.required' => 'Mô tả không được để trống',
            'stt_new.integer' => 'Số thứ tự phải là số nguyên.',
            'stt_new.min' => 'Số thứ tự phải lớn 0',
            'title_seo.required' => 'Tiêu đề trang không được bỏ trống.',
            'keyword_seo.required' => 'Thẻ từ khóa không được bỏ trống.',
            'des_seo.required' => 'Thẻ mô tả không được bỏ trống.',
        ];
    }
}
