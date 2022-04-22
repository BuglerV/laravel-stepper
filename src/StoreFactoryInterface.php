<?php

namespace Buglerv\Stepper;

use Buglerv\Stepper\Stores\StepperStoreInterface;

interface StoreFactoryInterface
{
    public function make( string $store = null ) : StepperStoreInterface;
}