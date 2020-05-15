<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\{Category, Post};
use App\Enums\PostStatusType;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.partials.blog._sidebar', function ($view) {
            $view->with('categories', Category::orderBy('name', 'asc')->get()->toTree());
        });

        View::composer('welcome', function ($view) {
            $view->with('latests', Post::orderBy('created_at', 'desc')->take(3)->get());
        });

        View::composer('welcome', function ($view) {
            $view->with('populars', Post::where('status', PostStatusType::Published)->orderBy('votes', 'desc')->take(6)->get());
        });
    }
}
