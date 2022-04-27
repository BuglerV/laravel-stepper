<?php

namespace Buglerv\Stepper;

use Buglerv\Stepper\Exceptions\StoreDoesntExist;
use Buglerv\Stepper\Stores\StepperStoreInterface;
use Illuminate\Support\Str;

class StoreFactory implements StoreFactoryInterface
{
    protected $default = 'database';
  
    public function make( string $store = null ) : StepperStoreInterface
    {
        $store = $store ?? config('stepper.store') ?? $this->default;
        
        $storeName = __namespace__ . '\\Stores\\' . Str::ucfirst("{$store}Store");
        
        if(! class_exists($storeName) ){
            throw new StoreDoesntExist("Storage '{$store}' doesnt exist.",$store);
        }
        
        return new $storeName;
    }
}