<?php

namespace Buglerv\Stepper;

use Illuminate\Support\ServiceProvider;
use Buglerv\Stepper\Stores\StepperStoreInterface;
use Buglerv\Stepper\Components\Info;
use Buglerv\Stepper\Console\Commands\CreateStepperCommand;

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
        $this->loads();
        
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateStepperCommand::class,
            ]);
        }
        
        $this->publishes([
            __DIR__.'/../config' => config_path(),
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/stepper'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/stepper')
        ],'stepper');
    }
    
   /**
    *  Все пути для пакета...
    */
    protected function loads()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
      
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'stepper');
        
        $this->loadViewComponentsAs('stepper', [
            Info::class,
        ]);
        
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'stepper');
    }
}
