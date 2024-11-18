<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompareCate extends Model
{
    use HasFactory;

    protected $table = 'compare_cate';

    const IS_PUBLIC = 1;
    const IS_NOT_PUBLIC = 0;

    protected $fillable = [
        'name', 'cate_id',
        'stt_compare', 'is_public'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }

    // Thiết lập mối quan hệ với Compare
    public function valueCompares()
    {
        return $this->hasMany(Compare::class, 'compare_cate_id', 'id');
    }
}