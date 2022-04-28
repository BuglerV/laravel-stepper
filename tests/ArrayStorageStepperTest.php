<?php

namespace Buglerv\Stepper\Tests;

class ArrayStorageStepperTest extends AbstractTestStorage
{
    /**
     * @return  string  Название хранилища...
     */
    protected static function storageName()
    {
        return 'array';
    }
}
