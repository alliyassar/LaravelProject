<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
    {
        // Kategorileri ve alt kategorileri tüm view dosyalara otomatik gönderiyoruz kanka
        view()->composer('*', function ($view) {
            $categories = \App\Models\Category::with('children')->get();
            $view->with('categories', $categories);
        });
    }
}
