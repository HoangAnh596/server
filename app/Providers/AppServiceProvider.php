<?php

namespace App\Providers;

use App\Models\CateFooter;
use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\CateMenu;
use App\Models\ContactIcon;
use App\Models\HeaderTag;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Services\CategoryNewSrc::class, function ($app) {
            return new \App\Services\CategoryNewSrc();
        });
        $this->app->singleton(\App\Services\CategorySrc::class, function ($app) {
            return new \App\Services\CategorySrc();
        });

        if (request()->is('admin*') || request()->is('login*') || request()->is('register*') || request()->is('password/*')) {
            $this->app->register(AdminServiceProvider::class);
        }

        // đảm bảo sql chỉ chạy 1 lần
        $this->app->singleton('menus', function () {
            return CateMenu::select('id', 'name', 'url', 'is_click', 'is_tab', 'image')
                ->where('parent_menu', 0)
                ->where('is_public', 1)
                ->orderBy('stt_menu', 'ASC')
                ->with(['children' => function ($query) {
                    $query->select('id', 'name', 'url', 'parent_menu', 'is_tab', 'is_click', 'image')
                        ->where('is_public', 1)
                        ->orderBy('stt_menu', 'ASC')
                        ->with(['children' => function ($subQuery) {
                            $subQuery->select('id', 'name', 'url', 'parent_menu', 'is_tab', 'is_click', 'image')
                                ->where('is_public', 1)
                                ->orderBy('stt_menu', 'ASC');
                        }]);
                }])
                ->get();
        });

        $this->app->singleton('categories', function () {
            return Category::select('id', 'name', 'slug', 'image', 'title_img', 'alt_img', 'is_outstand', 'is_serve')
                ->where('is_public', 1)
                ->where('parent_id', 0)
                ->with(['children' => function ($query) {
                    $query->select('id', 'name', 'slug', 'parent_id', 'is_outstand', 'is_serve')
                        ->where('is_public', 1)
                        ->orderBy('stt_cate', 'ASC')
                        ->with(['children' => function ($subQuery) {
                            $subQuery->select('id', 'name', 'slug', 'parent_id', 'is_outstand', 'is_serve')
                                ->where('is_public', 1)
                                ->orderBy('stt_cate', 'ASC');
                        }]);
                }])
                ->orderBy('stt_cate', 'ASC')->get();
        });

        $this->app->singleton('footers', function () {
            return CateFooter::select('id', 'name', 'url', 'is_tab')
                ->where('is_public', 1)
                ->where('parent_menu', 0)
                ->orderBy('stt_menu', 'ASC')
                ->with(['children' => function ($query) {
                    $query->select('id', 'name', 'url', 'is_tab', 'parent_menu', 'is_click')
                        ->where('is_public', 1)
                        ->orderBy('stt_menu', 'ASC');
                }])
                ->get();
        });

        $this->app->singleton('searchCate', function () {
            // Lấy dữ liệu từ cả hai bảng và hợp lại
            $categories = Category::where('parent_id', 0)
                ->select('id', 'name')
                ->get()
                ->map(function ($item) {
                    $item->source = 'prod'; // Gán giá trị 'source' cho Category
                    return $item;
                });

            // Lấy dữ liệu từ bảng CategoryNew và thêm trường 'source' để phân biệt
            $cateNews = CategoryNew::where('parent_id', 0)
                ->select('id', 'name')
                ->get()
                ->map(function ($item) {
                    $item->source = 'news'; // Gán giá trị 'source' cho CategoryNew
                    return $item;
                });

            return $categories->concat($cateNews);
        });

        // Thẻ tiếp thị
        $this->app->singleton('headerTags', function () {
            return HeaderTag::select('id', 'content')->where('is_public', 1)->get();
        });
        // Cấu hình icon liên hệ
        $this->app->singleton('contact-icons', function () {
            return ContactIcon::select('id', 'url', 'name', 'image', 'animation')->where('is_public', 1)->orderBy('stt', 'ASC')->get();
        });

        // Setting
        $this->app->singleton('setting', function () {
            return Setting::select('title_seo', 'keyword_seo', 'des_seo', 'image', 'facebook', 'twitter', 'youtube', 'tiktok', 'pinterest')->where('id', 1)->first();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\Category::observe(\App\Observers\CategoryObserver::class);
        \App\Models\Product::observe(\App\Observers\ProductObserver::class);
        \App\Models\News::observe(\App\Observers\NewObserver::class);

        Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        // Cấu hình gửi mail báo
        $settings = Setting::select('id', 'mail_name', 'mail_pass', 'mail_text')->where('id', 1)->first();
        if ($settings) {
            // Cập nhật config với các giá trị từ bản ghi settings
            Config::set('mail.mailers.smtp.username', $settings->mail_name);
            Config::set('mail.mailers.smtp.password', $settings->mail_pass);
            Config::set('mail.from.address', $settings->mail_name);
            Config::set('mail.from.name', $settings->mail_text);
            // Cập nhật các giá trị khác tương tự
        }
        
        View::composer('*', function ($view) {
            $globalMenus = $this->app->make('menus');
            $globalCategories = $this->app->make('categories');
            $globalFooters = $this->app->make('footers');
            $searchCate = $this->app->make('searchCate');
            $globalHeaderTags = $this->app->make('headerTags');
            $globalSetting = $this->app->make('setting');
            $contactIconGlobal = $this->app->make('contact-icons');

            $view->with('globalMenus', $globalMenus)->with('globalFooters', $globalFooters)
                ->with('globalCategories', $globalCategories)->with('searchCate', $searchCate)
                ->with('globalHeaderTags', $globalHeaderTags)
                ->with('globalSetting', $globalSetting)
                ->with('contactIconGlobal', $contactIconGlobal);
        });
    }
}
