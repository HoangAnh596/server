<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    use HasFactory;

    protected $table = 'product_tag';
    // protected $dates = ['deleted_at'];
    protected $fillable = [ 
        'name', 'code', 'slug',
        'price', 'image', 'related_pro',
        'title_img', 'alt_img',
        'title_seo', 'keyword_seo', 'des_seo',
        'maker_id', 'image_ids',
        'content'
    ];
}
