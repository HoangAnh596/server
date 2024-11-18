<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Infor;
use App\Models\News;
use App\Models\Product;
use App\Models\ProductImages;
use App\Services\CategorySrc;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Sitemap;

class CreateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->generateMainSitemap();
        $this->generateCategorySitemap();
        $this->generateProductSitemap();
        $this->generateNewSitemap();

        // $this->info('Sitemaps generated successfully.');
        
    }

    protected function generateMainSitemap()
    {
        $sitemap = App::make('sitemap');
        // add home pages mặc định
        // $sitemap->add((config('app.url'). "/sitemap.xml"), Carbon::now('Asia/Ho_Chi_Minh'), '1.0', 'daily');
        $sitemap->add((config('app.url'). "/danhmuc.xml"), Carbon::now('Asia/Ho_Chi_Minh'), '0.9', 'daily');
        $sitemap->add((config('app.url'). "/sanpham.xml"), Carbon::now('Asia/Ho_Chi_Minh'), '0.9', 'daily');
        $sitemap->add((config('app.url'). "/tintuc.xml"), Carbon::now('Asia/Ho_Chi_Minh'), '0.9', 'daily');

        $sitemap->store('xml', 'sitemap', public_path(), null, null, false);
        // File::copy(public_path('sitemap.xml'), base_path('sitemap.xml'));
        if (File::exists(base_path() . '/sitemap.xml')) {
            File::copy(public_path('sitemap.xml'), base_path('sitemap.xml'));
        }
    }
    protected function generateCategorySitemap()
    {
        $sitemap = App::make('sitemap');

        $sitemap->add(config('app.url'), '', '1.0', 'daily');
        $categories = Category::orderBy('id', 'DESC')->paginate(500);
        foreach ($categories as $category) {
            $sitemap->add(config('app.url'). "/{$category->slug}", $category->updated_at, '0.8', 'weekly');
        }
        // Lưu file sitemap danh mục
        $sitemap->store('xml', 'danhmuc', public_path(), null, null, false);
        if (File::exists(base_path() . '/danhmuc.xml')) {
            File::copy(public_path('danhmuc.xml'), base_path('danhmuc.xml'));
        }
    }

    protected function generateProductSitemap()
    {
        $sitemap = App::make('sitemap');

        $sitemap->add(config('app.url'), '', '1.0', 'daily');
        $products = Product::orderBy('id', 'DESC')->paginate(500);
        foreach ($products as $pro) {
            $sitemap->add(config('app.url'). "/{$pro->slug}", $pro->updated_at, '0.8', 'weekly');
        }
        // Lưu file sitemap danh mục
        $sitemap->store('xml', 'sanpham', public_path(), null, null, false);
        if (File::exists(base_path() . '/sanpham.xml')) {
            File::copy(public_path('sanpham.xml'), base_path('sanpham.xml'));
        }
    }

    protected function generateNewSitemap()
    {
        $sitemap = App::make('sitemap');

        $sitemap->add(config('app.url'), '', '1.0', 'daily');
        $news = News::orderBy('id', 'DESC')->paginate(500);
        foreach ($news as $new) {
            $sitemap->add(config('app.url'). "/{$new->slug}", $new->updated_at, '0.8', 'weekly');
        }
        // Lưu file sitemap danh mục
        $sitemap->store('xml', 'tintuc', public_path(), null, null, false);
        if (File::exists(base_path() . '/tintuc.xml')) {
            File::copy(public_path('tintuc.xml'), base_path('tintuc.xml'));
        }
    }
}
