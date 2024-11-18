<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'sliders';

    const IS_PUBLIC = 1;
    const IS_NOT_PUBLIC = 0;

    protected $fillable = [
        'name', 'title', 'url', 'url_text',
        'image', 'description', 'user_id',
        'is_color', 'is_public', 'stt_slider'
    ];
}
