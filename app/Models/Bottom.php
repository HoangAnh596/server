<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bottom extends Model
{
    use HasFactory;

    protected $table = 'bottom';

    const IS_PUBLIC = 1;
    const IS_NOT_PUBLIC = 0;

    protected $fillable = [
        'name', 'url',
        'stt', 'is_public'
    ];
}
