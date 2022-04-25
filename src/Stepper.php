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
    *  Создает экземпляр класса...
    *
    *  @param \Buglerv\Stepper\Stores\StepperStoreInterface $store
    */
    public function __construct(StepperStoreInterface $store)
    {
        $this->store = $store;
    }
  
   /*
    *  Инициирует новый степпер...
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
    *  Получаем класс за степпером...
    */
    public function get(string $name) : object
    {
        $options = $this->getOptions($name);
        
        $class = "{$options->class}_step{$options->step}";
        
        return app($class);
    }
  
   /**
    *  Шагаем назад...
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
    *  Шагаем вперед...
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
    *  Возвращает текущий шаг степпера...
    */
    public function current(string $name) : int
    {
        return $this->getOptions($name)->step;
    }
  
   /**
    *  Проверяем существование степпера...
    */
    public function has(string $name) : bool
    {
        return $this->store->has($this->getRealName($name));
    }
   
   /**
    *  Уничтожаем сохраненный степпер...
    */
    public function remove(string $name)
    {
        unset(self::$options[$name]);
        
        $this->store->remove($this->getRealName($name));
    }
  
   /**
    *  Получаем опции степпера.
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
    *  Сохраняем опции степпера.
    */
    protected function putOptions($name,$options)
    {
        self::$options[$name] = $options;

        return $this->store->put($this->getRealName($name),$options);
    }
    
   /**
    *  Если необходимо как-то преобразовать
    *  $name, то делать это здесь...
    */
    protected function getRealName(string $name) : string
    {
        return 'stepper_' . $name;
    }
    
   /**
    *  Вид отображения прогресса степпера
    */
    public function getView() : string
    {
        return self::$view;
    }
    
   /**
    *  Вид отображения прогресса степпера
    */
    public function setView(string $view)
    {
        if(!view()->exists($view)){
            throw new RuntimeException("[Stepper] Try to assign unexisting view '{$view}'.");
        }
        
        self::$view = $view;
    }
}