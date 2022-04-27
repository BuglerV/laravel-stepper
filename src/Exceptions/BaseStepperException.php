<?php

namespace Buglerv\Stepper\Exceptions;

use Illuminate\Support\Facades\Log;
use RuntimeException;

abstract class BaseStepperException extends RuntimeException
{
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
    public function __construct($message,$param)
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
        Log::build([
          'driver' => 'single',
          'path' => config('stepper.log-file'),
        ])->error($this->message);
        
        return 1;
    }
}

