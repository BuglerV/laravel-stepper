<?php

namespace Buglerv\Stepper\Stores;

use Buglerv\Stepper\StepperOptionsBag;

class ArrayStore implements StepperStoreInterface
{
   /**
    *  Здесь храним параметры степпера...
    */
    protected $data = [];
  
   /**
    *  Сохраняет опции степпера, используя $name
    *  как ключ, а $options как значение...
    *
    *  @param string $name
    *  @param StepperOptionsBag $options
    *  @return boolean
    */
    public function put(string $name, StepperOptionsBag $options)
    {
        $this->data[$name] = $options->getAll();
    }
    
   /**
    *  Получает опции степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return array
    */
    public function get(string $name)
    {
        return new StepperOptionsBag($this->data[$name] ?? []);
    }
    
   /**
    *  Удаляет опции степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return boolean
    */
    public function remove(string $name)
    {
        unset($this->data[$name]);
    }

   /**
    *  Проверяет наличие опций степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return boolean
    */
    public function has(string $name) : bool
    {
        return isset($this->data[$name]);
    }
}