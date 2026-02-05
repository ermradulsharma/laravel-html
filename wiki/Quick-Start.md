# Quick Start Guide

## Basic Form

```php
{!! Form::open(['url' => 'users/store']) !!}
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name') !!}

    {!! Form::label('email', 'Email') !!}
    {!! Form::email('email') !!}

    {!! Form::submit('Create User') !!}
{!! Form::close() !!}
```

## With Model Binding

```php
{!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}
    {!! Form::text('name') !!}
    {!! Form::email('email') !!}
    {!! Form::submit('Update') !!}
{!! Form::close() !!}
```

## Using Blade Components

```blade
<x-form-input name="name" label="Name" />
<x-form-input name="email" type="email" label="Email" />
<x-form-textarea name="bio" label="Biography" />
<x-form-select name="country" :options="$countries" label="Country" />
<x-form-checkbox name="agree" value="1" label="I agree to terms" />
```

## With Theme Support

```php
// Bootstrap
{!! Form::open(['url' => 'save'])->bootstrap() !!}
    {!! Form::text('email') !!}
{!! Form::close() !!}

// Tailwind
{!! Form::open(['url' => 'save'])->tailwind() !!}
    {!! Form::text('email') !!}
{!! Form::close() !!}
```

Or set globally in `config/html.php`:

```php
'theme' => 'bootstrap',
```

## With Validation

```php
{!! Form::open(['url' => 'save']) !!}
    {!! Form::rules('required|email|max:255')->text('email') !!}
    {!! Form::rules('required|min:8')->password('password') !!}
    {!! Form::submit('Submit') !!}
{!! Form::close() !!}
```

## With Livewire

```php
{!! Form::wireSubmitPrevent('save')->open('POST') !!}
    {!! Form::wire('user.name')->text('name') !!}
    {!! Form->wireLive('search', 300)->text('search') !!}
    {!! Form::wireClick('submit')->submit('Save') !!}
{!! Form::close() !!}
```

## Common Inputs

```php
// Text inputs
{!! Form::text('username') !!}
{!! Form::email('email') !!}
{!! Form::password('password') !!}
{!! Form::url('website') !!}
{!! Form::tel('phone') !!}

// Textarea
{!! Form::textarea('bio', null, ['rows' => 5]) !!}

// Select
{!! Form::select('country', ['US' => 'United States', 'UK' => 'United Kingdom']) !!}

// Checkboxes and Radios
{!! Form::checkbox('agree', 1, true) !!}
{!! Form::radio('gender', 'male') !!}

// File upload
{!! Form::file('avatar') !!}

// Buttons
{!! Form::submit('Save') !!}
{!! Form::button('Click Me') !!}
{!! Form::reset('Reset Form') !!}
```

## Next Steps

- [Form Builder Guide](Form-Builder.md) - Complete form documentation
- [Smart Inputs](Smart-Inputs.md) - Advanced input features
- [Examples](Examples.md) - Real-world examples
