<?php

namespace Buglerv\Stepper\Stores;

use Illuminate\Support\Facades\Db;
use Buglerv\Stepper\StepperOptionsBag;

class DatabaseStore implements StepperStoreInterface
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
        Db::table('stepper')->updateOrInsert([
            'name' => $name,
        ],[
            'options' => json_encode($options->getAll()),
        ]);
    }
    
   /**
    *  Получает опции степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return array
    */
    public function get(string $name)
    {
        $options = Db::table('stepper')
                     ->where('name',$name)
                     ->first('options')
                     ->options;
        $options = json_decode($options);
        
        return new StepperOptionsBag( $options ?? [] );
    }
    
   /**
    *  Удаляет опции степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return boolean
    */
    public function remove(string $name)
    {
        Db::table('stepper')->where('name',$name)->delete();
    }

   /**
    *  Проверяет наличие опций степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return boolean
    */
    public function has(string $name) : bool
    {
        return Db::table('stepper')->where('name',$name)->count();
    }
}