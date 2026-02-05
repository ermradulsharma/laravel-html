<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Theme
    |--------------------------------------------------------------------------
    |
    | This option controls the default CSS framework theme used by the builders.
    | Supported: "tailwind", "bootstrap", or null for no theme.
    |
    */

    'theme' => null,

    /*
    |--------------------------------------------------------------------------
    | Theme Classes
    |--------------------------------------------------------------------------
    |
    | Here you can customize the classes applied to each element type for
    | the built-in themes, or define your own custom themes.
    |
    */

    'themes' => [
        'tailwind' => [
            'input'    => 'border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none block w-full',
            'checkbox' => 'rounded border-gray-300 text-blue-600 focus:ring-blue-500',
            'radio'    => 'text-blue-600 focus:ring-blue-500',
            'select'   => 'border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none block w-full',
            'textarea' => 'border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none block w-full',
            'submit'   => 'bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition',
            'button'   => 'bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded transition',
            'label'    => 'block text-gray-700 text-sm font-bold mb-2',
            'error'    => 'text-red-500 text-xs italic mt-1',
        ],
        'bootstrap' => [
            'input'    => 'form-control',
            'checkbox' => 'form-check-input',
            'radio'    => 'form-check-input',
            'select'   => 'form-select',
            'textarea' => 'form-control',
            'submit'   => 'btn btn-primary',
            'button'   => 'btn btn-secondary',
            'label'    => 'form-label',
            'error'    => 'invalid-feedback d-block',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Honeypot Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the honeypot anti-spam protection.
    |
    */

    'honeypot' => [
        'name'      => 'my_name',
        'time_name' => 'my_time',
    ],

];
