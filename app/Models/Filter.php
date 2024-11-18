<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;

    protected $table = 'filter';

    protected $fillable = [
        'key_word',
        'search',
        'filter_id',
        'stt'
    ];

    public function product()
    {
        return $this->belongsToMany('App\Models\Product', 'filters_products', 'filter_id', 'product_id');
    }
}
