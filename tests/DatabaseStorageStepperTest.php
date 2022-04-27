<?php

namespace Buglerv\Stepper\Tests;

use Tests\TestCase;
use Buglerv\Stepper\StoreFactory;
use Buglerv\Stepper\Stepper;

use Buglerv\Stepper\Tests\Controllers\TestController;

class DatabaseStorageStepperTest extends TestCase
{
    /**
     * @var  \Buglerv\Stepper\Stepper  Экземпляр степпера...
     */
    protected $storage;
    
    /**
     * @var  string  Название хранилища...
     */
    protected $storageName = 'database';
    
    /**
     * @var  string  Имя степпера...
     */
    protected $name = 'stepper_test';
  
    /**
     * Создаем рабочий экземпляр степпера...
     */
    public function __construct()
    {
        $this->stepper = new Stepper((new StoreFactory)->make($this->storageName));
        
        parent::__construct(...func_get_args());
    }
    
    public function test_stepper_can_init()
    {
        $this->assertDatabaseMissing('stepper',[
            'name' => $this->name
        ]);
        
        $this->stepper->init($this->name,TestController::class);
        
        $this->assertDatabaseHas('stepper',[
            'name' => $this->name
        ]);
        
        $this->stepper->remove($this->name);
    }
}



