<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use App\View\Composers\ActivityComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::aliasComponent('components.badge', 'badge');
        Blade::aliasComponent('components.updated', 'updated');
        Blade::aliasComponent('components.card', 'card');
        Blade::aliasComponent('components.tags', 'tags');
        Blade::aliasComponent('components.errors', 'errors');
        Blade::aliasComponent('components.comments-form', 'commentForm');
        Blade::aliasComponent('components.comments-list', 'commentList');

        view()->composer(['posts.index', 'posts.show'], ActivityComposer::class);
        
    }
}
