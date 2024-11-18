<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name', 'code', 'slug', 'subCategory',
        'price', 'related_pro', 'status',
        'title_seo', 'keyword_seo', 'des_seo',
        'maker_id', 'image_ids', 'tag_ids',
        'des', 'content', 'is_outstand', 'discount'
    ];

    protected $casts = [
        'images_id' => 'array',
        'tag_id' => 'array',
        'related_id' => 'array',
        'subCategory' => 'array'
    ];

    protected $appends = ['average_star', 'totalCmt'];

    // relation Question
    public function questionProduct()
    {
        return $this->hasMany(Question::class, 'product_id', 'id');
    }

    // Getter for average_star
    public function getAverageStarAttribute()
    {
        // Tính trung bình sao từ bảng comments
        $totalStarCount = Comment::where('product_id', $this->id)->sum('star');
        $totalCommentsWithStar = Comment::where('product_id', $this->id)
            ->whereNotNull('star')
            ->where('star', '>', 0)
            ->count();

        return $totalCommentsWithStar > 0 ? $totalStarCount / $totalCommentsWithStar : 0;
    }

    // Getter for totalCmt
    public function getTotalCmtAttribute()
    {
        // Lấy tổng số bản ghi comment có sao
        return Comment::where('product_id', $this->id)
            ->whereNotNull('star')
            ->where('star', '>', 0)
            ->count();
    }

    public function getRelatedProducts()
    {
        if (!empty($this->related_pro)) {
            $relatedIds = json_decode($this->related_pro);
            return Product::whereIn('id', $relatedIds)->get();
        }
    }

    public function getProductTags()
    {
        if (!empty($this->tag_ids)) {
            $tagId = json_decode($this->tag_ids);
            return ProductTag::whereIn('id', $tagId)->get();
        }
    }

    public function getProductImages()
    {
        if (!empty($this->image_ids)) {
            $imgId = json_decode($this->image_ids);
            return ProductImages::whereIn('id', $imgId)->orderBy('stt_img', 'ASC')->get();
        }
    }

    public function loadProductImages()
    {
        $imageIds = json_decode($this->image_ids, true);

        if (!empty($imageIds)) {
            $this->product_images = ProductImages::whereIn('id', $imageIds)
                ->orderBy('updated_at', 'DESC')
                ->get();
        } else {
            $this->product_images = collect(); // Thiết lập là một tập hợp rỗng
        }
    }

    public function getMainImage()
    {
        $this->loadProductImages();

        // Lọc ảnh chính
        $mainImages = $this->product_images->filter(function ($image) {
            return $image->main_img == 1;
        });

        // Nếu có ít nhất một ảnh chính, sắp xếp theo updated_at giảm dần và lấy ảnh mới nhất
        if ($mainImages->isNotEmpty()) {
            return $mainImages->sortByDesc('updated_at')->first();
        }

        // Nếu không có ảnh chính nào, trả về null hoặc ảnh mặc định
        return null;
    }

    public function category()
    {
        return $this->belongsToMany('App\Models\Category', 'product_categories', 'product_id', 'category_id');
    }
    // relation tới filter
    public function filters()
    {
        return $this->belongsToMany('App\Models\Filter', 'filters_products', 'product_id', 'filter_id');
    }

    // relation compare
    public function compares()
    {
        return $this->belongsToMany(Compare::class, 'compare_products')
                    ->withPivot('display_compare', 'value_compare')
                    ->withTimestamps();
    }

    // Thiết lập mối quan hệ với groups
    public function groups()
    {
        return $this->belongsToMany('App\Models\Group', 'group_products', 'product_id', 'group_id')
                    ->withPivot('is_checked');
    }

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'id', 'image_ids');
    }

    public function tags()
    {
        return $this->hasMany(ProductTag::class, 'id', 'tag_ids');
    }

    public function relatedProducts()
    {
        return $this->hasMany(Product::class, 'id', 'related_pro');
    }

    public function getImages()
    {
        return ProductImages::whereIn('id', $this->image_ids ?: [])->get();
    }

    public function getTags()
    {
        return ProductTag::whereIn('id', $this->tag_ids ?: [])->get();
    }

    public function getRelatedPro()
    {
        return Product::whereIn('id', $this->related_pro ?: [])->get();
    }
}
