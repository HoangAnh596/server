<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ProductFormRequest extends FormRequest
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
        $productId = $params['id'] ?? null;
        $imageIds = json_decode($params['image_ids'] ?? '[]', true);
        // Đảm bảo $imageIds là một mảng, nếu không chuyển nó thành một mảng rỗng
        if (!is_array($imageIds)) {
            $imageIds = [];
        }
        // Kiểm tra nếu sản phẩm có id
        if (!empty($params['id'])) {
            $checkNameUpdate = DB::table('products')
                ->where('name', '=', $params['name'])
                ->where('id', '=', $params['id'])
                ->exists();

            if ($checkNameUpdate) {
                $ruleUpdateName = "required";
            }
        }

        // Kiểm tra tính duy nhất của slug trong cả hai bảng
        $uniqueSlugRule = function ($attribute, $value, $fail) use ($params) {
            $slugExistsInProducts = DB::table('products')
                ->where('slug', $value)
                ->where('id', '!=', $params['id'] ?? 0)
                ->exists();

            $slugExistsInCategory = DB::table('categories')
                ->where('slug', $value)
                ->exists();

            if ($slugExistsInCategory || $slugExistsInProducts) {
                $fail('URL đã tồn tại. Vui lòng thay đổi url khác.');
            }
        };

        // Đặt điều kiện cho slug
        $slugRule = !empty($params['id'])
            ? ['in:' . DB::table('products')->where('id', $params['id'])->value('slug'), $uniqueSlugRule]
            : ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $uniqueSlugRule];

        return [
            'name' => isset($ruleUpdateName) ? $ruleUpdateName : 'required|unique:products',
            'content' => 'required',
            'category' => 'required',
            'image' => !empty($params['id']) ? '' : 'required',
            'slug' => $slugRule,
            'code' => [
                'required',
                'regex:/^(?!-)(?!.*--)[A-Za-z0-9-]+(?<!-)$/',
                Rule::unique('products')->ignore($productId)
            ],
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
            'name.required' => 'Tên sản phẩm không được bỏ trống.',
            'name.unique' => 'Tên sản phẩm đã tồn tại. Vui lòng thay đổi tên khác.',
            'code.required' => 'Mã sản phẩm không được để trống',
            'code.regex' => 'Mã sản phẩm chỉ được chứa chữ cái, số và dấu gạch ngang.',
            'code.unique' => 'Mã sản phẩm đã tồn tại. Vui lòng thay đổi mã khác.',
            'category.required' => 'Danh mục sản phẩm không được để trống',
            'content.required' => 'Mô tả không được để trống',
            'image.required' => 'Ảnh không được để trống',
            'slug.required' => 'Url không được bỏ trống.',
            'slug.unique' => 'URL đã tồn tại. Vui lòng thay đổi url khác.',
            'slug.regex' => 'Url chỉ được phép chứa chữ cái thường, số và dấu gạch ngang.',
            'slug.in' => 'Không được thay đổi slug',
            'title_seo.required' => 'Tiêu đề trang không được bỏ trống.',
            'keyword_seo.required' => 'Thẻ từ khóa không được bỏ trống.',
            'des_seo.required' => 'Thẻ mô tả không được bỏ trống.',
        ];
    }
}
