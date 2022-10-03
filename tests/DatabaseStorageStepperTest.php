<?php

namespace Buglerv\Stepper\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseStorageStepperTest extends AbstractTestStorage
{
    use RefreshDatabase;
	
    /**
     * @return  string  Название хранилища...
     */
    protected static function storageName()
    {
        return 'database';
    }
	
	/**
	 * Get package providers.
	 *
	 * @param  \Illuminate\Foundation\Application  $app
	 *
	 * @return array<int, string>
	 */
	protected function getPackageProviders($app)
	{
		return [
			'Buglerv\Stepper\StepperServiceProvider',
		];
	}
}
