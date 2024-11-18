<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImages extends Model
{
    use HasFactory;

    protected $table = 'product_images';
    
    protected $fillable = [
        'image', 'main_img',
        'title',
        'alt',
        'stt_img'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
