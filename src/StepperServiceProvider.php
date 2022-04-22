<?php

namespace Buglerv\Stepper;

use Illuminate\Support\ServiceProvider;
use Buglerv\Stepper\Stores\StepperStoreInterface;
use Buglerv\Stepper\Components\Info;

class StepperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StepperStoreInterface::class,function($app){
            return (new StoreFactory)->make();
        });
        
        $this->mergeConfigFrom(
            __DIR__.'/../config/stepper.php', 'stepper'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
      
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'stepper');
        
        $this->loadViewComponentsAs('stepper', [
            Info::class,
        ]);
        
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'stepper');
    }
}
