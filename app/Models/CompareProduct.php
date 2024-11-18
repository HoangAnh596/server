<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompareProduct extends Model
{
    use HasFactory;

    protected $table = 'compare_products';

    protected $fillable = [
        'product_id', 'compare_id',
        'display_compare', 'value_compare',
    ];

}