<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateFooter extends Model
{
    use HasFactory;

    protected $table = 'cate_footer';

    const IS_CLICK = 1;
    const IS_NOT_CLICK = 0;
    const IS_TAB = 1;
    const IS_NOT_TAB = 0;
    const IS_PUBLIC = 1;
    const IS_NOT_PUBLIC = 0;

    protected $fillable = [
        'name', 'title', 'parent_menu',
        'url', 'content', 'stt_menu',
        'is_click', 'is_tab', 'is_public'
    ];

    public function children()
    {

        return $this->hasMany(CateFooter::class, 'parent_menu')->with('children');
    }

    public function parent()
    {

        return $this->belongsTo(CateFooter::class, 'parent_menu')->with('parent');
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
