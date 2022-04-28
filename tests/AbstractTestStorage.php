<?php

namespace Buglerv\Stepper\Tests;

use Buglerv\Stepper\StepperOptionsBag;
use Buglerv\Stepper\StoreFactory;
use Buglerv\Stepper\Stepper;
use Buglerv\Stepper\Tests\Controllers\TestController;
use LogicException;
use Tests\TestCase;

abstract class AbstractTestStorage extends TestCase
{
    /**
     * @var  \Buglerv\Stepper\Stepper  Экземпляр степпера...
     */
    protected static $stepper;
    
    /**
     * @var  string  Имя степпера...
     */
    protected static $name = 'test';
  
    /**
     * Создаем рабочий экземпляр степпера...
     */
    public static function setUpBeforeClass() : void
    {
        static::$stepper = new Stepper((new StoreFactory)->make(static::storageName()));
    }
    
    /**
     * @return  string  Название хранилища...
     */
    protected static function storageName()
    {
        throw new LogicException('You need to overwrite ['. static::class .'::storageName()] static method.');
    }
    
    /**
     * @test
     */
    public function can_init()
    {
        if(static::$stepper->has(static::$name)){
            static::$stepper->remove(static::$name);
        }
      
        $this->assertFalse(static::$stepper->has(static::$name));
      
        static::$stepper->init(static::$name,TestController::class);
        
        $this->assertTrue(static::$stepper->has(static::$name));
    }
    
    /**
     * @test
     * @depends can_init
     */
    public function can_get_object()
    {
        $this->assertIsObject(static::$stepper->get(static::$name));
    }
    
    /**
     * @test
     * @depends can_get_object
     */
    public function can_walk_on()
    {
        $this->assertTrue(static::$stepper->forward(static::$name));
        $this->assertTrue(static::$stepper->forward(static::$name));
        $this->assertFalse(static::$stepper->forward(static::$name));
        $this->assertSame(3,static::$stepper->current(static::$name));
        $this->assertTrue(static::$stepper->back(static::$name,1));
        $this->assertFalse(static::$stepper->back(static::$name));
    }
    
    /**
     * @test
     * @depends can_walk_on
     */
    public function can_get_options()
    {
        $options = static::$stepper->getOptions(static::$name);
        
        $this->assertIsObject($options);
        $this->assertEquals(StepperOptionsBag::class,get_class($options));
    }
    
    
    /**
     * Удаляем тестовые опции степпера, если они есть...
     *
     * @test
     * @depends can_get_options
     */
    public function can_remove()
    {
        static::$stepper->remove(static::$name);
        
        $this->assertFalse(static::$stepper->has(static::$name));
    }
}
