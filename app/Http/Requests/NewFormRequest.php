<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class NewFormRequest extends FormRequest
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
            $checkNameUpdate = DB::table('news')->select('id')
                ->where('name', '=', $params['name'])
                ->where('id', '=', $params['id'])
                ->value('id');
        }
        if (!empty($params['id']) && ($params['id'] == $checkNameUpdate)) {
            $ruleUpdateName = "required | max:255";
        } else {
            $ruleUpdateName = 'required | max:255 | unique:news';
        }

        // Kiểm tra tính duy nhất của slug trong cả hai bảng
        $uniqueSlugRule = function ($attribute, $value, $fail) use ($params) {
            $slugExistsInCategory = DB::table('news')
                ->where('slug', $value)
                ->where('id', '!=', $params['id'] ?? 0)
                ->exists();

            $slugExistsInNews = DB::table('category_news')
                ->where('slug', $value)
                ->exists();

            if ($slugExistsInCategory || $slugExistsInNews) {
                $fail('URL đã tồn tại. Vui lòng thay đổi url khác.');
            }
        };

        // Đặt điều kiện cho slug
        $slugRule = !empty($params['id'])
            ? ['in:' . DB::table('news')->where('id', $params['id'])->value('slug'), $uniqueSlugRule]
            : ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $uniqueSlugRule];

        return [
            'name' => $ruleUpdateName,
            'slug' => $slugRule,
            'cate_id' => 'required',
            'filepath' => 'required',
            'desc' => 'required',
            'stt_new' => (!empty($params['stt_new'])) ? 'integer|min:0' : '',
            'content'=>'required',
            'title_seo' => 'required',
            'keyword_seo' => 'required',
            'des_seo' => 'required',
        ];
    }
    // validate
    public function messages()
    {
        return [
            'name.required' => 'Tên bài viết không được để trống',
            'name.unique' => 'Tên bài viết đã tồn tại. Vui lòng thay đổi tên khác.',
            'name.max' => 'Tên bài viết không được quá 255 ký tự',
            'content.required' => 'content không được để trống',
            'filepath.required' => 'Ảnh không được để trống',
            'slug.required' => 'Url không được bỏ trống.',
            'slug.unique' => 'URL đã tồn tại. Vui lòng thay đổi url khác.',
            'slug.regex' => 'Url chỉ được phép chứa chữ cái thường, số và dấu gạch ngang.',
            'slug.in' => 'Không được thay đổi slug',
            'cate_id.required' => 'Danh mục bài viết không được để trống',
            'desc.required' => 'Mô tả ngắn không được để trống',
            'title_seo.required' => 'Tiêu đề trang không được bỏ trống.',
            'keyword_seo.required' => 'Thẻ từ khóa không được bỏ trống.',
            'des_seo.required' => 'Thẻ mô tả không được bỏ trống.',
        ];
    }
}