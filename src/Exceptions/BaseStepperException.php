<?php

namespace Buglerv\Stepper\Exceptions;

use Illuminate\Support\Facades\Log;
use RuntimeException;

abstract class BaseStepperException extends RuntimeException
{
    /**
     * @var  bool  Выводить ли в лог Trace исключения...
     */
    protected $trace = true;
    
    /**
     * @var  string  Сообщение...
     */
    protected $message;
    
    /**
     * @var  string
     */
    protected $param;
  
    /**
     * @param  $message  Сообщение...
     * @param  $param
     */
    public function __construct($message,$param=null)
    {
        $this->message = $message;
        $this->param = $param;
    }
  
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        $message = $this->getLogMessage();
        $trace = $this->trace
                      ? $this->getTraceAsString()
                      : "{$this->getFile()}:{$this->getLine()}";
      
        Log::build([
          'driver' => 'single',
          'path' => config('stepper.log-file'),
        ])->error("{$message}\n{$trace}");
        
        return 1;
    }
    
    /**
     * Возвращаем сообщение исключения для записи в лог.
     *
     * @return string
     */
    protected function getLogMessage()
    {
        return $this->message;
    }
}

