<?php

namespace Buglerv\Stepper;

namespace Buglerv\Stepper\Traits\ChainableMethods;
use Buglerv\Stepper\Stores\StepperStoreInterface;
use RuntimeException;

class Stepper implements StepperInterface
{
    use ChainableMethods;
  
   /*
    *  @var \Buglerv\Stepper\Stores\StepperStoreInterface
    */
    protected $store;
  
   /*
    *  @var string
    */
    protected static $view = 'stepper::components.info';
  
   /*
    *  @var array <Buglerv\Stepper\StepperOptionsBag>
    */
    protected static $options = [];
    
   /**
    *  ������� ������� �����...
    *
    *  @param \Buglerv\Stepper\Stores\StepperStoreInterface $store
    */
    public function __construct(StepperStoreInterface $store)
    {
        $this->store = $store;
    }
  
   /*
    *  ���樨��� ���� �⥯���...
    *
    *  @param  string  $name
    *  @param  string  $class
    *  @return  \Buglerv\Stepper\StepperOptionsBag
    */
    public function init(string $name, string $class)
    {
        $steps = 0;
        while(class_exists("{$class}_step" . ($steps + 1)))
        {
            $steps++;
        }
     
        if(!$steps){
            throw(new RuntimeException("You need to create [{$class}_step1] class."));
        }          
     
        $options = new StepperOptionsBag([
            'step' => 1,
            'steps' => $steps,
            'name' => $name,
            'class' => $class,
            'max' => 1,
        ]);
        
        $this->putOptions($name,$options);
        
        return $options;
    }
  
   /**
    *  ����砥� ����� �� �⥯��஬...
    */
    public function get(string $name) : object
    {
        $options = $this->getOptions($name);
        
        $class = "{$options->class}_step{$options->step}";
        
        return app($class);
    }
  
   /**
    *  ������ �����...
    */
    public function back(string $name, int $step = null) : bool
    {
        $options = $this->getOptions($name);
        
        if($step AND $step != $options->step){
            if($step > $options->max){
                return false;
            }
            $options->step = $step;
        }else{
            if($options->step == 1){
                return false;
            }
            $options->step--;
        }
        
        $this->putOptions($name,$options);
        
        return true;
    }
    
   /**
    *  ������ ���।...
    */
    public function forward(string $name) : bool
    {
        $options = $this->getOptions($name);

        if($options->step >= $options->steps){
            return false;
        }
        
        $options->step++;
        
        $options->max = $options->step > $options->max
                            ? $options->step
                            : $options->max;
        
        $this->putOptions($name,$options);
        
        return true;
    }
    
   /**
    *  �����頥� ⥪�騩 蠣 �⥯���...
    */
    public function current(string $name) : int
    {
        return $this->getOptions($name)->step;
    }
  
   /**
    *  �஢��塞 ����⢮����� �⥯���...
    */
    public function has(string $name) : bool
    {
        return $this->store->has($this->getRealName($name));
    }
   
   /**
    *  ����⮦��� ��࠭���� �⥯���...
    */
    public function remove(string $name)
    {
        unset(self::$options[$name]);
        
        $this->store->remove($this->getRealName($name));
    }
  
   /**
    *  ����砥� ��樨 �⥯���.
    */
    public function getOptions($name)
    {
        if(!isset(self::$options[$name])){
            if(!$this->store->has($this->getRealName($name)))
            {
                throw new RuntimeException("[Stepper] Options with name '{$name}' doesnt exist.");
            }
          
            self::$options[$name] = $this->store->get($this->getRealName($name));
        }
        
        return self::$options[$name];
    }
    
   /**
    *  ���࠭塞 ��樨 �⥯���.
    */
    protected function putOptions($name,$options)
    {
        self::$options[$name] = $options;

        return $this->store->put($this->getRealName($name),$options);
    }
    
   /**
    *  �᫨ ����室��� ���-� �८�ࠧ�����
    *  $name, � ������ �� �����...
    */
    protected function getRealName(string $name) : string
    {
        return 'stepper_' . $name;
    }
    
   /**
    *  ��� �⮡ࠦ���� �ண��� �⥯���
    */
    public function getView() : string
    {
        return self::$view;
    }
    
   /**
    *  ��� �⮡ࠦ���� �ண��� �⥯���
    */
    public function setView(string $view)
    {
        if(!view()->exists($view)){
            throw new RuntimeException("[Stepper] Try to assign unexisting view '{$view}'.");
        }
        
        self::$view = $view;
    }
}