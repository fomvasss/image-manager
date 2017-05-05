<?php

namespace Fomvasss\ImageManager;


use Fomvasss\ImageManager\Services\ImageManager;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/image_manager.php';
        $publishPath = config_path('image_manager.php');

        $this->publishes([$configPath => $publishPath], 'config');


//        for Facade
//        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
//        $loader->alias('ImageManager', 'Fomvasss\ImageManager\Facades\ImageManager');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ImageManager', function($app){
            return new ImageManager();
        });

        $configPath = __DIR__ . '/../config/image_manager.php';
        $this->mergeConfigFrom($configPath, 'ImageManager');
    }
}
