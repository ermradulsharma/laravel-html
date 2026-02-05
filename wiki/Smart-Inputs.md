# Smart Inputs

Advanced input components with built-in functionality.

## HTML5 Validation Rules

Automatically convert Laravel validation rules to HTML5 attributes:

```php
// Email with max length
{!! Form::rules('required|email|max:255')->text('email') !!}
// Generates: <input required type="email" maxlength="255">

// Numeric with min/max
{!! Form::rules('required|numeric|min:1|max:100')->text('age') !!}
// Generates: <input required type="number" min="1" max="100">

// String with min length
{!! Form::rules('required|min:8')->password('password') !!}
// Generates: <input required type="password" minlength="8">

// URL validation
{!! Form::rules('required|url')->text('website') !!}
// Generates: <input required type="url">

// Between values
{!! Form::rules('numeric|between:18,65')->text('age') !!}
// Generates: <input type="number" min="18" max="65">

// Regex pattern
{!! Form::rules('regex:/^[A-Z]{3}$/')->text('code') !!}
// Generates: <input pattern="^[A-Z]{3}$">
```

### Supported Rules

- `required` → `required`
- `email` → `type="email"`
- `url` → `type="url"`
- `numeric`, `integer` → `type="number"`
- `min:X` → `minlength="X"` or `min="X"` (for numbers)
- `max:X` → `maxlength="X"` or `max="X"` (for numbers)
- `between:X,Y` → `min="X" max="Y"` (for numbers)
- `regex:pattern` → `pattern="pattern"`

## Toggle/Switch Component

iOS-style toggle switches:

```php
// Basic toggle
{!! Form::toggle('notifications', 1, true) !!}

// With label
{!! Form::toggle('newsletter', 1, false, ['label' => 'Subscribe to newsletter']) !!}

// Bootstrap theme
{!! Form::toggle('dark_mode', 1, $user->dark_mode, ['label' => 'Dark Mode']) !!}

// Tailwind theme
{!! Form::toggle('public', 1, true, ['label' => 'Make profile public']) !!}

// With Livewire
{!! Form::wire('settings.notifications')->toggle('notifications', 1) !!}
```

## Color Picker

Native HTML5 color input:

```php
// Basic color picker
{!! Form::colorPicker('brand_color') !!}

// With default value
{!! Form::colorPicker('theme_color', '#3490dc') !!}

// With model binding
{!! Form::model($settings) !!}
    {!! Form::colorPicker('primary_color') !!}
{!! Form::close() !!}
```

## Rating Component

Star rating display and input:

```php
// Display only (readonly)
{!! Html::rating('product_rating', 5, 4.5, ['readonly' => true]) !!}

// Interactive rating input
{!! Html::rating('review_rating', 5, 0) !!}

// Custom max stars
{!! Html::rating('satisfaction', 10, 7) !!}

// With name for form submission
{!! Html::rating('rating', 5, $product->rating) !!}
```

## Complete Example

```php
{!! Form::open(['route' => 'profile.update']) !!}

    {{-- Validated text input --}}
    {!! Form::label('name', 'Full Name') !!}
    {!! Form::rules('required|min:3|max:100')->text('name') !!}

    {{-- Email with validation --}}
    {!! Form::label('email', 'Email Address') !!}
    {!! Form::rules('required|email|max:255')->text('email') !!}

    {{-- Toggle switch --}}
    {!! Form::toggle('notifications', 1, true, ['label' => 'Email Notifications']) !!}

    {{-- Color picker --}}
    {!! Form::label('theme_color', 'Theme Color') !!}
    {!! Form::colorPicker('theme_color', '#3490dc') !!}

    {{-- Rating --}}
    {!! Form::label('satisfaction', 'Satisfaction Rating') !!}
    {!! Html::rating('satisfaction', 5, 0) !!}

    {!! Form::submit('Save Settings') !!}

{!! Form::close() !!}
```

## Next Steps

- [Advanced Selects](Advanced-Selects.md) - Searchable and multi-select
- [Date & Time](Date-Time.md) - Date pickers
- [File Uploads](File-Uploads.md) - File upload with preview
