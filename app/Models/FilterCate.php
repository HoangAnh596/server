<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterCate extends Model
{
    use HasFactory;

    protected $table = 'filter_cate';

    const IS_LEFT = 1;
    const IS_RIGHT = 0;
    const IS_ONE = 1;
    const IS_MANY = 0;
    const IS_PUBLIC = 1;
    const IS_NOT_PUBLIC = 0;

    protected $fillable = [
        'name', 'slug', 'query',
        'cate_id', 'stt_filter', 'is_public'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }

    // Thiết lập mối quan hệ với Filter
    public function valueFilters()
    {
        return $this->hasMany(Filter::class, 'filter_id', 'id')->orderBy('stt', 'ASC');
    }
}
