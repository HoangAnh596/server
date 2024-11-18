<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $table = 'quotes';

    protected $fillable = [
        'name', 'phone', 'gmail',
        'product', 'quantity',
        'purpose', 'status'
    ];

    // Thiết lập quan hệ đến User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
