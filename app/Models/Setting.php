<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'setting';

    protected $fillable = [
        'title_seo', 'keyword_seo', 'des_seo',
        'mail_name', 'mail_pass', 'mail_text',
        'image', 'user_id', 'facebook', 'twitter',
        'youtube', 'tiktok', 'pinterest'
    ];
}
