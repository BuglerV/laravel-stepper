<?php

namespace Buglerv\Stepper\Stores;

use Buglerv\Stepper\StepperOptionsBag;

interface StepperStoreInterface
{
   /**
    *  Сохраняет опции степпера, используя $name
    *  как ключ, а $options как значение...
    *
    *  @param string $name
    *  @param \Buglerv\Stepper\StepperOptionsBag $options
    *  @return boolean
    */
    public function put(string $name, StepperOptionsBag $options);
    
   /**
    *  Получает опции степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return \Buglerv\Stepper\StepperOptionsBag
    */
    public function get(string $name);
    
   /**
    *  Удаляет опции степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return boolean
    */
    public function remove(string $name);
    
   /**
    *  Проверяет наличие опций степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return boolean
    */
    public function has(string $name) : bool;
}