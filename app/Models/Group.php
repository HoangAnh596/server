<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';

    protected $fillable = [
        'name', 'parent_id', 'is_type',
        'cate_id', 'is_public', 'stt',
    ];

    // Thiết lập mối quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }

    // Thiết lập mối quan hệ với groupProduct
    public function products()
    {
        return $this->belongsToMany(Product::class, 'group_products', 'group_id', 'product_id')
                    ->withPivot('is_checked');
    }
}
