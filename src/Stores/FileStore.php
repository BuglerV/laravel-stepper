<?php

namespace Buglerv\Stepper\Stores;

use Illuminate\Support\Facades\Storage;
use Buglerv\Stepper\StepperOptionsBag;

class FileStore implements StepperStoreInterface
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
        Storage::put(
            $this->realName($name),
            json_encode($options->getAll())
        );
    }
    
   /**
    *  Получает опции степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return array
    */
    public function get(string $name)
    {
        $options = json_decode(Storage::get($this->realName($name)));
        return new StepperOptionsBag( $options );
    }
    
   /**
    *  Удаляет опции степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return boolean
    */
    public function remove(string $name)
    {
        Storage::delete($this->realName($name));
    }

   /**
    *  Проверяет наличие опций степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return boolean
    */
    public function has(string $name) : bool
    {
        return Storage::exists($this->realName($name));
    }
    
   /**
    *  @param  string $name
    *  @return string
    */
    protected function realName($name)
    {
        return 'stepper/' . $name;
    }
}