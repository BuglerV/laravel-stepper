<?php

namespace Buglerv\Stepper;

use Illuminate\Support\Str;
use RuntimeException;

use Buglerv\Stepper\Stores\StepperStoreInterface;

class StoreFactory implements StoreFactoryInterface
{
    protected $default = 'database';
  
    public function make( string $store = null ) : StepperStoreInterface
    {
        $store = $store ?? config('stepper.store') ?? $this->default;
        
        $storeName = __namespace__ . '\\Stores\\' . Str::ucfirst("{$store}Store");
        
        if(! class_exists($storeName) ){
            throw new RuntimeException("[Stepper] Class '{$storeName}' doesnt exist.");
        }
        
        return new $storeName;
    }
}