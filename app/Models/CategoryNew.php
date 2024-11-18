<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryNew extends Model
{
    use HasFactory;

    protected $table = 'category_news'; 

    const IS_MENU = 1;
    const IS_NOT_MENU = 0;
    const IS_TOP_OUTSTAND = 1;
    const IS_NOT_OUTSTAND = 0;
    const IS_PUBLIC = 1;
    const IS_NOT_PUBLIC = 0;

    protected $fillable = [
        'name', 'slug',
        'related_pro', 'content', 'parent_id',
        'title_seo', 'keyword_seo', 'des_seo', 'stt_new',
        'is_menu', 'is_outstand', 'is_public'
    ];

    public function children()
    {
        return $this->hasMany(CategoryNew::class, 'parent_id')->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(CategoryNew::class, 'parent_id')->with('parent');
    }

    public function getRelatedPro()
    {
        $relatedIds = json_decode($this->related_pro);
        return Product::whereIn('id', $relatedIds)->get();
    }

    public function newProducts()
    {
        return $this->hasMany(Product::class, 'id', 'related_pro');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'id', 'cate_id');
    }
    // Lấy tất cả các bậc cha
    public function getAllParents()
    {
        $parents = collect();
        $parent = $this->parent;
        while ($parent) {
            $parents->prepend($parent);
            $parent = $parent->parent;
        }
        return $parents;
    }

    public function getAllChildrenIds()
    {
        $childrenIds = $this->children()->pluck('id')->toArray();

        foreach ($this->children as $child) {
            $childrenIds = array_merge($childrenIds, $child->getAllChildrenIds());
        }

        return $childrenIds;
    }
}
