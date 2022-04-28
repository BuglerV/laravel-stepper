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
     * @var  \Buglerv\Stepper\Stepper  ��������� �⥯���...
     */
    protected static $stepper;
    
    /**
     * @var  string  ��� �⥯���...
     */
    protected static $name = 'test';
  
    /**
     * ������� ࠡ�稩 ������� �⥯���...
     */
    public static function setUpBeforeClass() : void
    {
        static::$stepper = new Stepper((new StoreFactory)->make(static::storageName()));
    }
    
    /**
     * ����塞 ��⮢� ��樨 �⥯���, �᫨ ��� ����...
     *
     * @afterClass
     */
    public static function can_remove() : void
    {
        static::$stepper->remove(static::$name);
    }
    
    /**
     * @return  string  �������� �࠭����...
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
     * @depends can_init
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
     * @depends can_init
     */
    public function can_get_options()
    {
        $options = static::$stepper->getOptions(static::$name);
        
        $this->assertIsObject($options);
        $this->assertEquals(StepperOptionsBag::class,get_class($options));
    }
}
