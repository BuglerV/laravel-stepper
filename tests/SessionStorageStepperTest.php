<?php

namespace Buglerv\Stepper\Tests;

class SessionStorageStepperTest extends AbstractTestStorage
{
    /**
     * @return  string  Название хранилища...
     */
    protected static function storageName()
    {
        return 'session';
    }
}
