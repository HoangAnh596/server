<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderTag extends Model
{
    use HasFactory;

    protected $table = 'header_tags';

    protected $fillable = [
        'tag_name', 'content',
        'is_public', 'user_id'
    ];
}
