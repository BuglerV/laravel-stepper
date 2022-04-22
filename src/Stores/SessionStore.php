<?php

namespace Buglerv\Stepper\Stores;

use Buglerv\Stepper\StepperOptionsBag;

class SessionStore implements StepperStoreInterface
{
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
        session([$name => $options->getAll()]);
    }
    
   /**
    *  Получает опции степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return array
    */
    public function get(string $name)
    {
        return new StepperOptionsBag( session($name,[]) );
    }
    
   /**
    *  Удаляет опции степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return boolean
    */
    public function remove(string $name)
    {
        session()->forget($name);
    }

   /**
    *  Проверяет наличие опций степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return boolean
    */
    public function has(string $name) : bool
    {
        return session()->has($name);
    }
}