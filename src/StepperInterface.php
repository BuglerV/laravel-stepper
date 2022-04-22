<?php

namespace Buglerv\Stepper;

interface StepperInterface
{
    // Создаем новый степпер...
    public function init(string $name, string $class);
    
    // Получаем класс за степпером...
    public function get(string $name) : object;
    // Получаем опции степпера.
    public function getOptions($name);
    
    // Удаляем степпер...
    public function remove(string $name);
    // Проверям существование степпера...
    public function has(string $name) : bool;
    
    // Возвращает текущий шаг степпера...
    public function current(string $name) : int;
    // Крутим степпер вперед...
    public function forward(string $name) : bool;
    // Крутим степпер назад...
    public function back(string $name, int $step = null) : bool;
    
    // Вид отображения прогресса степпера
    public function getView() : string;
    public function setView(string $view);
}