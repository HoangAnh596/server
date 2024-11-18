<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compare extends Model
{
    use HasFactory;

    protected $table = 'compare';

    protected $fillable = [
        'key_word', 'compare_cate_id',
        'display_compare', 'value_compare',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'compare_products')
                    ->withPivot('display_compare', 'value_compare')
                    ->withTimestamps();
    }
}
