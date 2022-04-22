<?php

namespace Buglerv\Stepper\Components;

use Illuminate\View\Component;
use Facades\Buglerv\Stepper\Stepper as StepperManager;

class Info extends Component
{
    /**
     *  @var array
     */
    public $options;
    
    /**
     *  @var array
     */
    public $percent;
  
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->options = StepperManager::getOptions($name);
        
        $this->percent = ($this->options->step / $this->options->steps) * 100;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view(StepperManager::getView());
    }
}
