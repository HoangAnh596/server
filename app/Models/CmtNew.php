<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmtNew extends Model
{
    use HasFactory;

    protected $table = 'cmt_news';

    protected $fillable = [
        'name', 'new_id', 'parent_id',
        'email', 'phone', 'slugNew',
        'content', 'user_id',
        'star', 'is_public'
    ];

    public function cmtNew()
    {
        return $this->belongsTo(News::class, 'new_id');
    }

    public function replies()
    {
        return $this->hasMany(CmtNew::class, 'parent_id')->with('replies');
    }

    public function cmtChild()
    {
        return $this->hasMany(CmtNew::class, 'parent_id')
            ->where('is_public', 1)
            ->with(['cmtChild' => function ($query) {
                $query->where('is_public', 1);
            }])->orderBy('created_at', 'DESC');
    }

    public function getAllChildrenIds()
    {
        $childrenIds = $this->replies()->pluck('id')->toArray();

        foreach ($this->replies as $child) {
            $childrenIds = array_merge($childrenIds, $child->getAllChildrenIds());
        }

        return $childrenIds;
    }
}
