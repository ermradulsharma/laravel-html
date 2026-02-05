# Livewire Integration

Complete guide to using Livewire with the Form Builder.

## Wire:model Helpers

### Basic Wire:model

```php
{!! Form::wire('email')->text('email') !!}
// Generates: <input wire:model="email" type="text" name="email">
```

### Wire:model.lazy

Syncs on blur instead of input:

```php
{!! Form::wireLazy('search')->text('search') !!}
// Generates: <input wire:model.lazy="search" type="text" name="search">
```

### Wire:model.defer

Syncs only on form submission:

```php
{!! Form::wireDefer('description')->textarea('description') !!}
// Generates: <textarea wire:model.defer="description" name="description"></textarea>
```

### Wire:model.live

Real-time syncing with optional debounce:

```php
{!! Form::wireLive('query')->text('query') !!}
// Generates: <input wire:model.live="query" type="text" name="query">

{!! Form::wireLive('search', 300)->text('search') !!}
// Generates: <input wire:model.live.debounce.300ms="search" type="text" name="search">
```

## Wire:click

```php
{!! Form::wireClick('save')->submit('Save') !!}
// Generates: <button wire:click="save" type="submit">Save</button>

{!! Form::wireClick('delete')->button('Delete') !!}
// Generates: <button wire:click="delete" type="button">Delete</button>
```

## Wire:submit

```php
{!! Form::wireSubmit('handleSubmit')->open('POST', '/save') !!}
// Generates: <form wire:submit="handleSubmit" method="POST" action="/save">

{!! Form::wireSubmitPrevent('save')->open('POST') !!}
// Generates: <form wire:submit.prevent="save" method="POST">
```

## Complete Livewire Component Example

### Component Class

```php
<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UserProfile extends Component
{
    public $user;
    public $search = '';
    public $selectedTags = [];

    public function mount($userId)
    {
        $this->user = User::find($userId);
        $this->selectedTags = $this->user->tags->pluck('id')->toArray();
    }

    public function save()
    {
        $this->validate([
            'user.name' => 'required|min:3',
            'user.email' => 'required|email',
        ]);

        $this->user->save();
        $this->user->tags()->sync($this->selectedTags);

        session()->flash('message', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
```

### Component View

```blade
<div>
    {!! Form::wireSubmitPrevent('save')->open('POST') !!}

        {{-- Real-time validation --}}
        {!! Form::wire('user.name')->rules('required|min:3')->text('name') !!}
        @error('user.name') <span class="error">{{ $message }}</span> @enderror

        {!! Form::wire('user.email')->rules('required|email')->text('email') !!}
        @error('user.email') <span class="error">{{ $message }}</span> @enderror

        {{-- Live search with debounce --}}
        {!! Form::wireLive('search', 300)->autocomplete('search', '/api/search') !!}

        {{-- Deferred updates --}}
        {!! Form::wireDefer('user.bio')->textarea('bio', null, ['rows' => 5]) !!}

        {{-- Multi-select with wire:model --}}
        {!! Form::wire('selectedTags')->multiSelect('tags', $tags) !!}

        {{-- Toggle with wire:model --}}
        {!! Form::wire('user.newsletter')->toggle('newsletter', 1, false, ['label' => 'Subscribe']) !!}

        {{-- Date picker with wire:model --}}
        {!! Form::wire('user.birthday')->datePicker('birthday') !!}

        {{-- Submit button --}}
        {!! Form::wireClick('save')->submit('Save Profile') !!}

    {!! Form::close() !!}

    @if (session()->has('message'))
        {!! Html::alert(session('message'), 'success', [], true) !!}
    @endif
</div>
```

## Advanced Patterns

### Conditional Rendering

```blade
{!! Form::wire('showAdvanced')->checkbox('show_advanced', 1) !!}

@if ($showAdvanced)
    {!! Form::wire('user.bio')->richText('bio', null, ['toolbar' => 'full']) !!}
    {!! Form::wire('user.website')->text('website') !!}
@endif
```

### Dynamic Forms

```blade
@foreach ($fields as $index => $field)
    {!! Form::wire("fields.{$index}.value")->text("field_{$index}") !!}
@endforeach

{!! Form::wireClick('addField')->button('Add Field') !!}
```

### File Uploads with Livewire

```blade
{{-- Use Livewire's file upload --}}
<input type="file" wire:model="photo">

@if ($photo)
    <img src="{{ $photo->temporaryUrl() }}">
@endif
```

## Combining with Smart Inputs

```blade
{!! Form::wireSubmitPrevent('save')->open('POST') !!}

    {{-- Validation rules + wire:model --}}
    {!! Form::wire('user.email')->rules('required|email|max:255')->text('email') !!}

    {{-- Toggle + wire:model --}}
    {!! Form->wire('settings.notifications')->toggle('notifications', 1) !!}

    {{-- Color picker + wire:model --}}
    {!! Form::wire('settings.theme_color')->colorPicker('theme_color') !!}

    {{-- Searchable select + wire:model --}}
    {!! Form::wire('user.country')->searchableSelect('country', $countries) !!}

    {!! Form::wireClick('save')->submit('Save') !!}

{!! Form::close() !!}
```

## Tips & Best Practices

1. **Use debounce for search**: `wireLive('search', 300)` prevents too many requests
2. **Use defer for large forms**: Reduces server requests until submission
3. **Validate on the server**: Always validate in your Livewire component
4. **Handle loading states**: Use `wire:loading` for better UX
5. **Optimize re-renders**: Use `wire:key` for dynamic lists

## Next Steps

- [Smart Inputs](Smart-Inputs.md) - Combine with validation rules
- [Examples](Examples.md) - More Livewire examples
- [API Reference](API-Reference.md) - All wire methods
