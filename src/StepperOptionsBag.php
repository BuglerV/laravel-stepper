<?php

namespace Buglerv\Stepper;

class StepperOptionsBag
{
   /*
    *  @var array
    */
    protected $data;
    
   /**
    *  Создает экземпляр класса...
    *
    *  @param array $data
    */
    public function __construct($data)
    {
        $this->data = collect($data)->toArray();
    }
    
   /**
    *  Возвращает все опции...
    *
    *  @return array
    */
    public function getAll()
    {
        return $this->data;
    }
    
   /*
    *  Геттер...
    */
    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }
    
   /*
    *  Сеттер...
    */
    public function __set($name,$value)
    {
        $this->data[$name] = $value;
    }
}