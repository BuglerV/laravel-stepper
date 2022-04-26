<?php

namespace Buglerv\Stepper;

use Buglerv\Stepper\Exceptions\StoreDoesntExistException;
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
            throw new StoreDoesntExistException($store);
        }
        
        return new $storeName;
    }
}