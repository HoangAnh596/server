<?php

namespace App\Providers;

use App\Models\CmtNew;
use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('comments', function () {
            return Comment::where('parent_id', 0)
                ->whereDoesntHave('replies')
                ->with('replies')
                ->get();
        });

        $this->app->singleton('cmtNew', function () {
            return CmtNew::where('parent_id', 0)
                ->whereDoesntHave('replies')
                ->with('replies')
                ->get();
        });

        $this->app->singleton('quotes', function () {
            return Quote::select('id', 'name', 'product', 'created_at')
                ->where('status', 0)
                ->orderBy('created_at', 'DESC')
                ->get();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $commentGlobal = $this->app->make('comments');
            $cmtNewGlobal = $this->app->make('cmtNew');
            $quoteGlobal = $this->app->make('quotes');

            $view->with('commentGlobal', $commentGlobal)
                ->with('cmtNewGlobal', $cmtNewGlobal)
                ->with('quoteGlobal', $quoteGlobal);
        });
    }
}
