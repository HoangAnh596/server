<?php

namespace App\Observers;

use App\Models\News;
use Illuminate\Support\Facades\Artisan;

class NewObserver
{
    /**
     * Handle the New "created" event.
     *
     * @param  \App\Models\New  $new
     * @return void
     */
    public function created(News $new)
    {
        \Artisan::call('sitemap:create');
    }

    /**
     * Handle the New "updated" event.
     *
     * @param  \App\Models\New  $new
     * @return void
     */
    public function updated(News $new)
    {
        \Artisan::call('sitemap:create');
    }

    /**
     * Handle the New "deleted" event.
     *
     * @param  \App\Models\New  $new
     * @return void
     */
    public function deleted(News $new)
    {
        \Artisan::call('sitemap:create');
    }

    /**
     * Handle the New "restored" event.
     *
     * @param  \App\Models\New  $new
     * @return void
     */
    public function restored(News $new)
    {
        //
    }

    /**
     * Handle the New "force deleted" event.
     *
     * @param  \App\Models\New  $new
     * @return void
     */
    public function forceDeleted(News $new)
    {
        //
    }
}
