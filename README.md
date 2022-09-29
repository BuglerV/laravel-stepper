# Laravel Stepper

Создает многошаговые контроллеры с сохранением результатов между шагами.

## Установка

`composer require buglerv/laravel-stepper`

`php artisan vendor:publish --provider=Buglerv\Stepper\StepperServiceProvider`

В случае использования хранилища базы данных:
`php artisan migrate`

## Применение

Для работы необходимо создать несколько контроллеров с одинаковыми именами и суффиксом `_step{шаг}`. К примеру `PersonController_step1` и `PersonController_step2`.

```php
use Facades\Buglerv\Stepper\Stepper;

$name = 'name'; // Любое уникальное имя по которому степпер будет идентифицироваться.

Stepper::init($name, 'PersonController'); // Степпер сам проверит какие классы существуют.

Stepper::get($name); // Класс PersonController_step1
Stepper::get($name)->doSomething(); // Вызов метода doSomething у контроллера PersonController_step1

Stepper::forward($name);
Stepper::get($name); // Класс PersonController_step2
Stepper::get($name)->doSomething(); // Вызов метода doSomething у контроллера PersonController_step2
Stepper::current($name); // 2

Stepper::back($name);
Stepper::get($name); // Класс PersonController_step1

Stepper::has($name); // true

Stepper::remove($name); // Удален.
```

Из отображения можно вывести полоску прогресса:
```blade
<x-stepper-info :name="$name"/>
```

Это выведет стандартное отображение. Но можно задать свое:
```php
Stepper:setView('путь/до/отображения');
```

## Хранилища

Возможны 4 варианта хранилища:

1) database - База данных.
2) file - Файлы.
3) session - Сессия.
4) array - По сути не сохраняет состояние между обновлениями страницы.

## Artisan команда

`php artisan stepper:create --steps=2 PersonController`

Создаст два контроллера `PersonController_step1` и `PersonController_step2`.

## Пример

[BuglerV/create-personage](https://github.com/BuglerV/create-personage)
