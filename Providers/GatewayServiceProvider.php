<?php

namespace Merdanio\GatewayTM\Providers;

use GatewayFacade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Merdiano\Payment\App\GatewayManager;

class GatewayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router){
        $this->publishes([
            __DIR__.'/../Config/gateway.php' => config_path('gateway.php'),
        ],'gateway');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'gateway');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(){
        $loader = AliasLoader::getInstance();
        $loader->alias('gateway', GatewayFacade::class);

        $this->app->singleton('gateway', function () {
            return new GatewayManager();
        });
    }
}
