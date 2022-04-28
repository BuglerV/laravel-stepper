<?php

namespace Buglerv\Stepper\Tests;

class FileStorageStepperTest extends AbstractTestStorage
{
    /**
     * @return  string  Название хранилища...
     */
    protected static function storageName()
    {
        return 'file';
    }
}
