<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view){
            $this->getViewName($view);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function getViewName($view) {
        View::share('view_name', $view->getName());
        View::share('js_name', 'sites/js.'.$view->getName());
        View::share('css_name', 'sites/css.'.$view->getName());
        View::share('banner_title', $this->formatUrlToTitle(Route::current()->uri()));
        View::share('menu', config('app.menu'));
    }

    protected function formatUrlToTitle ($url) {
        if(strpos($url, '/')) {
            $cutUrlPos = strpos($url, '/');
            $url = substr($url, 0, $cutUrlPos);
        }
        return strtoupper(str_replace('-', ' ', $url));
    }
}
