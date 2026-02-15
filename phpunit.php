<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Events\Dispatcher;

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require __DIR__ . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Set The Default Timezone
|--------------------------------------------------------------------------
|
| Here we will set the default timezone for PHP. PHP is notoriously mean
| if the timezone is not explicitly set. This will be used by each of
| the PHP date and date-time functions throughout the application.
|
*/

date_default_timezone_set('UTC');

/*
 * Prepare the db connection (spoofing that shit)
 */
$capsule = new Capsule;
$capsule->addConnection([
  'driver'   => 'sqlite',
  'database' => ':memory:',
]);
$capsule->setEventDispatcher(new Dispatcher);
$capsule->setAsGlobal();
$capsule->bootEloquent();

/*
|--------------------------------------------------------------------------
| Setup Config Repository
|--------------------------------------------------------------------------
*/
$container = $capsule->getContainer();
$container->singleton('config', function () {
  return new \Illuminate\Config\Repository([
    'html' => [
      'theme' => null,
      'themes' => [],
    ],
  ]);
});

// Ensure the Facade knows about the container
\Illuminate\Support\Facades\Facade::setFacadeApplication($container);

if (!function_exists('config')) {
  /**
   * Get / set the specified configuration value.
   *
   * If an array is passed as the key, we will assume you want to set an array of values.
   *
   * @param  array|string|null  $key
   * @param  mixed  $default
   * @return mixed|\Illuminate\Config\Repository
   */
  function config($key = null, $default = null)
  {
    $config = \Illuminate\Support\Facades\Facade::getFacadeApplication()->make('config');

    if (is_null($key)) {
      return $config;
    }

    if (is_array($key)) {
      return $config->set($key);
    }

    return $config->get($key, $default);
  }
}

$capsule->schema()->dropIfExists('models');

$capsule->schema()->create('models', function (Blueprint $table) {
  $table->increments('id');
  $table->string('string');
  $table->string('email');
  $table->timestamps();
});
