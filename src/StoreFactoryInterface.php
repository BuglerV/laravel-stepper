<?php

namespace Buglerv\Stepper;

use Buglerv\Stepper\Stores\StepperStoreInterface;

interface StorefactoryInterface
{
    public function make( string $store = null ) : StepperStoreInterface;
}