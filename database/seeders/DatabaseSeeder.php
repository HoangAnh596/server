<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\CmtNew;
use App\Models\Comment;
use App\Models\Maker;
use App\Models\News;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\Quote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // dd(1);
        // \App\Models\User::factory(5000)->create();
        // Category::factory(500)->create();
        // CategoryNew::factory(500)->create();
        // News::factory(10000)->create();
        // Comment::factory(5000)->create();
        // CmtNew::factory(5000)->create();
        // Quote::factory(10000)->create();
        // Product::factory(5000)->create();

        // ProductImages::factory(100)->create();
        // bảng tb product_categories có product_id và category_id
        // product_id random từ 1-7000
        // category_id random từ 1-500

        // Seed dữ liệu cho bảng product_categories
        // $productIds = Product::pluck('id')->toArray(); // Lấy tất cả product_id
        // $categoryIds = Category::pluck('id')->toArray(); // Lấy tất cả category_id

        // Tạo dữ liệu seed ngẫu nhiên cho product_categories
        // for ($i = 0; $i < 15495; $i++) { // Seed 10,000 bản ghi (tùy chỉnh số lượng)
        //     DB::table('product_categories')->insert([
        //         'product_id' => $productIds[array_rand($productIds)], // Random product_id từ 1-7000
        //         'category_id' => $categoryIds[array_rand($categoryIds)], // Random category_id từ 1-500
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
    }
}
