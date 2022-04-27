<?php

namespace Buglerv\Stepper\Tests;

use Tests\TestCase;
use Buglerv\Stepper\StoreFactory;
use Buglerv\Stepper\Stepper;

use Buglerv\Stepper\Tests\Controllers\TestController;

abstract class AbstractTestStorage extends TestCase
{
    /**
     * @var  \Buglerv\Stepper\Stepper  Экземпляр степпера...
     */
    protected $stepper;
    
    /**
     * @var  string  Название хранилища...
     */
    abstract protected $storageName;
    
    /**
     * @var  string  Имя степпера...
     */
    protected $name = 'test';
  
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
        $this->assertFalse($this->stepper->has($this->name));
      
        $this->stepper->init($this->name,TestController::class);
        
        $this->assertTrue($this->stepper->has($this->name));
        
        $this->stepper->remove($this->name);
        
        $this->assertFalse($this->stepper->has($this->name));
    }
    
    public function test_stepper_walk()
    {
        $this->stepper->init($this->name,TestController::class);
        
        $class = $this->stepper->get($this->name);
        $this->assertIsObject($class);
        
        $this->assertTrue($this->stepper->forward($this->name));
        $this->assertTrue($this->stepper->forward($this->name));
        $this->assertFalse($this->stepper->forward($this->name));
        $this->assertTrue($this->stepper->back($this->name,1));
        $this->assertFalse($this->stepper->back($this->name));
        
        $this->stepper->remove($this->name);
    }
}



