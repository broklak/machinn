<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
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
        View::share('menu', $this->getMenu());
        View::share('user', Auth::user());
        View::share('master_module', $this->getMasterModuleName());
        View::share('route_name', $this->getRoutingModule());
    }

    protected function formatUrlToTitle ($url) {
        if(strpos($url, '/')) {
            $cutUrlPos = strpos($url, '/');
            $url = substr($url, 0, $cutUrlPos);
        }
        return strtoupper(str_replace('-', ' ', $url));
    }

    protected function getMasterModuleName (){
        $name = Request::segment(2);
        if($name == null){
            $name = config('app.defaultRoute');
        }
        return ucwords(str_replace('-', ' ', $name));
    }

    protected function getRoutingModule(){
        $route = Route::currentRouteName();
        if($route == null){
            return config('app.defaultRoute');
        }
        $name = explode('.', $route);
        return $name[0];
    }

    protected function getMenu () {
        $menu = Cache::get('menu');
//        echo json_encode($menu); die;
        return $menu;
    }
}
