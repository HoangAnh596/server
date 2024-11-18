<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupProduct extends Model
{
    use HasFactory;

    protected $table = 'group_products';

    protected $fillable = [
        'product_id', 'group_id',
        'is_checked'
    ];
    
    // Thiết lập mối quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
