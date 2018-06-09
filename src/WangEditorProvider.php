<?php

/*
 * This file is part of the sohenk/wangeditor.
 *
 * (c) sohenk <sohenk@sohenk.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sohenk\WangEditor;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class WangEditorProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'initialize');

        $this->publishes([
            __DIR__.'/config/wangeditor.php' => config_path('wangeditor.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/assets/wangeditor' => public_path('vendor/wangeditor'),
        ], 'assets');

        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/wangeditor')
        ], 'resources');

        if (!app()->runningInConsole()) {
            $this->registerRoute($router);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/wangeditor.php', 'wangeditor');
    }

    /**
     * Register routes.
     *
     * @param $router
     */
    public function registerRoute($router)
    {
        if (!$this->app->routesAreCached()) {
            $router->group(
                array_merge(
                    ['namespace' => __NAMESPACE__],
                    config('wangeditor.route.options'
                    )
                ), function ($router) {
                $router->any(
                    config('wangeditor.route.url', '/wangeditor/server'),
                    'WangEditorController@serve'
                );
            });
        }
    }
}
