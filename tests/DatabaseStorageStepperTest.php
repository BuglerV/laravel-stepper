<?php

namespace Buglerv\Stepper\Tests;

class DatabaseStorageStepperTest extends AbstractTestStorage
{
    /**
     * @return  string  Название хранилища...
     */
    protected static function storageName()
    {
        return 'database';
    }
}
