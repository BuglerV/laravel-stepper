<?php

namespace Buglerv\Stepper\Stores;

use Illuminate\Support\Facades\DB;
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
        DB::table('stepper')->updateOrInsert([
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
        $options = DB::table('stepper')
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
        DB::table('stepper')->where('name',$name)->delete();
    }

   /**
    *  Проверяет наличие опций степпера, используя $name как ключ...
    *
    *  @param string $name
    *  @return boolean
    */
    public function has(string $name) : bool
    {
        return DB::table('stepper')->where('name',$name)->count();
    }
}