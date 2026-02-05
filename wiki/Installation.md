# Installation

## Requirements

- PHP 8.0 or higher
- Laravel 7.0 or higher

## Installation via Composer

```bash
composer require skywalker/laravel-html
```

## Service Provider Registration

The package will automatically register its service provider in Laravel 5.5+.

For older versions, add to `config/app.php`:

```php
'providers' => [
    // ...
    Skywalker\Html\HtmlServiceProvider::class,
],

'aliases' => [
    // ...
    'Form' => Skywalker\Html\FormFacade::class,
    'Html' => Skywalker\Html\HtmlFacade::class,
],
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=html-config
```

This creates `config/html.php` where you can customize:

### Theme Selection

```php
'theme' => 'bootstrap', // or 'tailwind' or null
```

### Theme Classes

```php
'themes' => [
    'bootstrap' => [
        'text' => 'form-control',
        'select' => 'form-select',
        'textarea' => 'form-control',
        'checkbox' => 'form-check-input',
        'radio' => 'form-check-input',
        'error' => 'is-invalid',
    ],
    'tailwind' => [
        'text' => 'border rounded px-4 py-2 w-full',
        'select' => 'border rounded px-4 py-2 w-full',
        'textarea' => 'border rounded px-4 py-2 w-full',
        'checkbox' => 'rounded',
        'radio' => 'rounded',
        'error' => 'border-red-500',
    ],
],
```

### Honeypot Configuration

```php
'honeypot' => [
    'name' => 'my_name',
    'time_name' => 'my_time',
],
```

## Verification

Test the installation:

```php
// In a Blade view
{!! Form::text('test') !!}
{!! Html::link('/', 'Home') !!}
```

## Next Steps

- [Quick Start Guide](Quick-Start.md)
- [Configuration Details](Configuration.md)
- [Form Builder Guide](Form-Builder.md)
