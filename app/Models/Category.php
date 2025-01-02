<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    const IS_SERVE = 1;
    const IS_NOT_SERVE = 0;
    const IS_TOP_PARENT = 1;
    const IS_NOT_PARENT = 0;
    const IS_MENU = 1;
    const IS_NOT_MENU = 0;
    const IS_TOP_OUTSTAND = 1;
    const IS_NOT_OUTSTAND = 0;
    const IS_PUBLIC = 1;
    const IS_NOT_PUBLIC = 0;

    protected $fillable = [
        'name', 'slug', 'parent_id', 'filter_ids',
        'image', 'title_img', 'alt_img', 'content',
        'title_seo', 'keyword_seo', 'des_seo', 'stt_cate', 'is_home',
        'infor_server', 'is_serve', 'is_parent',
        'is_menu', 'is_outstand', 'is_public'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_categories', 'category_id', 'product_id');
    }

    public function children()
    {

        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {

        return $this->belongsTo(Category::class, 'parent_id')->with('parent');
    }

    public function getAllChildrenIds()
    {
        $childrenIds = $this->children()->pluck('id')->toArray();

        foreach ($this->children as $child) {
            $childrenIds = array_merge($childrenIds, $child->getAllChildrenIds());
        }

        return $childrenIds;
    }
    // Lấy ra id của cha có parent_id = 0
    public function topLevelParent()
    {
        $category = $this->select('id', 'parent_id', 'name', 'slug', 'filter_ids', 'is_serve')->where('id', $this->id)->first();
        while ($category->parent_id != 0) {
            $category = $category->parent()->select('id', 'parent_id', 'name', 'slug', 'filter_ids', 'is_serve')->first();
        }
        return $category;
    }

    public function getAllParents()
    {
        $parents = collect();
        $parent = $this->parent()->select('id', 'parent_id', 'name', 'slug', 'is_public')->first();
        while ($parent) {
            $parents->prepend($parent);
            $parent = $parent->parent()->select('id', 'parent_id', 'name', 'slug', 'is_public')->first();
        }
        return $parents;
    }

    // Lấy ra các id cha của nó và cả chính nó
    public function getAllParentIds()
    {
        $category = $this;
        $ids = collect(); // Tạo một collection để lưu các ID

        // Vòng lặp đệ quy để lấy ID của tất cả các danh mục cha
        while ($category) {
            $ids->push($category->id); // Thêm ID của chính nó hoặc cha vào danh sách
            $category = $category->parent; // Tiếp tục di chuyển lên danh mục cha
        }

        return $ids->toArray(); // Trả về mảng các ID
    }
    
    // Thiết lập mối quan hệ với FilterCate
    public function filters()
    {
        return $this->hasMany(FilterCate::class, 'cate_id', 'id');
    }

    public function getFilterCates()
    {
        if (!empty($this->filter_ids)) {
            $filId = json_decode($this->filter_ids);
            return FilterCate::select('id', 'name', 'slug', 'cate_id', 'top_filter', 'special')->whereIn('id', $filId)
                ->where('is_public', 1)
                ->orderBy('stt_filter', 'ASC')->get();
        }
    }

    public function getCompareCates()
    {
        if (!empty($this->compare_ids)) {
            $compId = json_decode($this->compare_ids);
            return CompareCate::select('id', 'name', 'cate_id')->whereIn('id', $compId)
                ->where('is_public', 1)
                ->orderBy('stt_compare', 'ASC')->get();
        }
    }

    // Nhân bản
    function cloneCategory($categoryId)
    {
        // Lấy thông tin của danh mục cần sao chép
        $category = Category::findOrFail($categoryId);

        // Sao chép danh mục chính (không bao gồm id)
        $newCategory = $category->replicate(); // Tạo một bản sao nhưng chưa lưu vào database
        $newCategory->name = $newCategory->name . ' (Copy)'; // Thêm chuỗi để phân biệt với bản gốc
        $newCategory->save(); // Lưu bản sao mới

        // // Sao chép danh mục con (nếu có)
        // cloneChildCategories($category->id, $newCategory->id);

        return $newCategory; // Trả về danh mục đã sao chép
    }

    // relation Question
    public function questionCate()
    {
        return $this->hasMany(Question::class, 'cate_id', 'id');
    }
}
