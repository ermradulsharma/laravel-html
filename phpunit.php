<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

if (!function_exists('config')) {
  function config($key = null, $default = null)
  {
    $configs = [
      'html.theme' => null,
      'html.themes' => [],
    ];

    if (is_null($key)) return $configs;
    if (is_array($key)) return null;

    return $configs[$key] ?? $default;
  }
}

$capsule = new Capsule;
$capsule->addConnection([
  'driver'   => 'sqlite',
  'database' => ':memory:',
]);
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Ensure some basic facade functionality for tests that might use it
\Illuminate\Support\Facades\Facade::setFacadeApplication(new Container);
