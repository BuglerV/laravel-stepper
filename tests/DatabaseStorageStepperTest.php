<?php

namespace Buglerv\Stepper\Tests;

use Tests\TestCase;
use Buglerv\Stepper\StoreFactory;
use Buglerv\Stepper\Stepper;

use App\Http\Controllers\TestController;

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
    public function setUpBeforeClass()
    {
        $this->stepper = new Stepper((new StoreFactory)->make($this->storageName));
    }
    
    public function stepper_can_init_test()
    {
        $this->assertDatabaseMissing('stepper',[
            'name' => $this->name
        ]);
        
        $this->stepper->init($this->name,TestController::class);
        
        $this->assertDatabaseHas('stepper',[
            'name' => $this->name
        ]);
    }
}



