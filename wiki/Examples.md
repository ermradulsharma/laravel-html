# Examples

Real-world usage examples for common scenarios.

## User Registration Form

```php
{!! Form::open(['route' => 'register', 'files' => true]) !!}

    <h2>Create Account</h2>

    {!! Form::rules('required|min:3|max:100')->text('name', null, ['placeholder' => 'Full Name']) !!}

    {!! Form::rules('required|email|max:255')->text('email', null, ['placeholder' => 'Email Address']) !!}

    {!! Form::rules('required|min:8')->password('password', ['placeholder' => 'Password']) !!}

    {!! Form::rules('required|same:password')->password('password_confirmation', ['placeholder' => 'Confirm Password']) !!}

    {!! Form::datePicker('birthday') !!}

    {!! Form::fileUpload('avatar', ['accept' => 'image/*', 'preview' => true]) !!}

    {!! Form::checkbox('agree', 1, false) !!} I agree to the terms and conditions

    {!! Form::submit('Create Account') !!}

{!! Form::close() !!}
```

## User Profile Edit

```php
{!! Form::model($user, ['route' => ['profile.update'], 'files' => true]) !!}

    {!! Form::text('name') !!}
    {!! Form::email('email') !!}
    {!! Form::datePicker('birthday', $user->birthday) !!}
    {!! Form::fileUpload('avatar', ['preview' => true]) !!}
    {!! Form::searchableSelect('country', $countries, $user->country) !!}
    {!! Form::multiSelect('interests', $interests, $user->interests) !!}
    {!! Form::colorPicker('theme_color', $user->theme_color) !!}
    {!! Form::toggle('newsletter', 1, $user->newsletter, ['label' => 'Email Newsletter']) !!}
    {!! Form::toggle('public_profile', 1, $user->public_profile, ['label' => 'Public Profile']) !!}

    {!! Form::submit('Update Profile') !!}

{!! Form::close() !!}
```

## Blog Post Editor

```php
{!! Form::model($post, ['route' => ['posts.update', $post], 'files' => true]) !!}

    {!! Form::rules('required|max:255')->text('title') !!}

    {!! Form::richText('content', $post->content, ['toolbar' => 'full']) !!}

    {!! Form::searchableSelect('category_id', $categories, $post->category_id) !!}

    {!! Form::multiSelect('tags', $tags, $post->tags->pluck('id')->toArray()) !!}

    {!! Form::fileUpload('featured_image', ['accept' => 'image/*', 'preview' => true]) !!}

    {!! Form::multipleFiles('attachments', ['max' => 5]) !!}

    {!! Form::toggle('published', 1, $post->published, ['label' => 'Publish']) !!}
    {!! Form::toggle('featured', 1, $post->featured, ['label' => 'Featured Post']) !!}

    {!! Form::submit('Update Post') !!}

{!! Form::close() !!}
```

## Event Booking Form

```php
{!! Form::open(['route' => 'events.book']) !!}

    {!! Form::searchableSelect('event_id', $events) !!}

    {!! Form::dateRangePicker('start_date', 'end_date') !!}

    {!! Form::timePicker('preferred_time', '09:00') !!}

    {!! Form::multiSelect('attendees', $users) !!}

    {!! Form::textarea('special_requests', null, ['rows' => 4]) !!}

    {!! Form::multipleFiles('attachments', ['max' => 3, 'accept' => '.pdf,.doc,.docx']) !!}

    {!! Form::submit('Book Event') !!}

{!! Form::close() !!}
```

## Multi-Step Wizard

```php
{!! Form::open(['route' => 'onboarding.complete']) !!}

{!! Form::wizard([
    'Personal Information' => [],
    'Account Details' => [],
    'Preferences' => [],
    'Review' => []
]) !!}

{{-- Step 1: Personal Information --}}
<div class="wizard-step-1">
    {!! Form::text('first_name') !!}
    {!! Form::text('last_name') !!}
    {!! Form::datePicker('birthday') !!}
    {!! Form::tel('phone') !!}
</div>

{{-- Step 2: Account Details --}}
<div class="wizard-step-2">
    {!! Form::email('email') !!}
    {!! Form::password('password') !!}
    {!! Form::password('password_confirmation') !!}
</div>

{{-- Step 3: Preferences --}}
<div class="wizard-step-3">
    {!! Form::colorPicker('theme_color', '#3490dc') !!}
    {!! Form::toggle('newsletter', 1, true, ['label' => 'Newsletter']) !!}
    {!! Form::toggle('notifications', 1, true, ['label' => 'Notifications']) !!}
    {!! Form::multiSelect('interests', $interests) !!}
</div>

{{-- Step 4: Review --}}
<div class="wizard-step-4">
    <p>Please review your information before submitting.</p>
</div>

{!! Form::close() !!}
```

## Livewire Component Form

```php
{!! Form::wireSubmitPrevent('save')->open('POST') !!}

    {!! Form::wire('user.name')->rules('required')->text('name') !!}

    {!! Form::wire('user.email')->rules('required|email')->text('email') !!}

    {!! Form::wireLive('search', 300)->autocomplete('search', '/api/search') !!}

    {!! Form::wire('user.country')->searchableSelect('country', $countries) !!}

    {!! Form::wire('user.tags')->multiSelect('tags', $tags) !!}

    {!! Form::wire('user.birthday')->datePicker('birthday') !!}

    {!! Form::wire('user.newsletter')->toggle('newsletter', 1) !!}

    {!! Form::wireClick('submit')->submit('Save') !!}

{!! Form::close() !!}
```

## Admin Dashboard

```php
<div class="dashboard">
    {{-- Progress indicators --}}
    <h3>Project Progress</h3>
    {!! Html::progressBar(85, ['variant' => 'success', 'striped' => true]) !!}
    {!! Html::progressBar(60, ['variant' => 'warning']) !!}
    {!! Html::progressBar(30, ['variant' => 'danger']) !!}

    {{-- Status badges --}}
    <h3>User Status {!! Html::badge('5', 'primary') !!}</h3>
    {!! Html::pill('Active', 'success') !!}
    {!! Html::pill('Pending', 'warning') !!}
    {!! Html::pill('Blocked', 'danger') !!}

    {{-- Tabs --}}
    {!! Html::tabs([
        'Overview' => view('dashboard.overview'),
        'Analytics' => view('dashboard.analytics'),
        'Settings' => view('dashboard.settings')
    ]) !!}

    {{-- Accordion FAQ --}}
    {!! Html::accordion([
        'How do I reset my password?' => 'Click on Forgot Password...',
        'How do I change my email?' => 'Go to Settings > Account...',
        'How do I delete my account?' => 'Contact support...'
    ]) !!}
</div>
```

## Search Form with Filters

```php
{!! Form::open(['route' => 'products.search', 'method' => 'GET']) !!}

    {!! Form::autocomplete('query', '/api/products/autocomplete', null, ['placeholder' => 'Search products...']) !!}

    {!! Form::searchableSelect('category', $categories, null, ['placeholder' => 'All Categories']) !!}

    {!! Form::dateRangePicker('date_from', 'date_to') !!}

    {!! Form::multiSelect('brands', $brands) !!}

    {!! Form::number('min_price', null, ['placeholder' => 'Min Price']) !!}
    {!! Form::number('max_price', null, ['placeholder' => 'Max Price']) !!}

    {!! Form::submit('Search') !!}
    {!! Form::button('Clear Filters', ['type' => 'reset']) !!}

{!! Form::close() !!}
```

## Contact Form

```php
{!! Form::open(['route' => 'contact.send']) !!}

    {!! Form::rules('required|min:3')->text('name', null, ['placeholder' => 'Your Name']) !!}

    {!! Form::rules('required|email')->text('email', null, ['placeholder' => 'Your Email']) !!}

    {!! Form::select('subject', [
        'general' => 'General Inquiry',
        'support' => 'Technical Support',
        'sales' => 'Sales',
        'other' => 'Other'
    ]) !!}

    {!! Form::rules('required|min:10')->textarea('message', null, ['rows' => 6, 'placeholder' => 'Your Message']) !!}

    {!! Form::multipleFiles('attachments', ['max' => 3]) !!}

    {!! Form::honeypot() !!}

    {!! Form::submit('Send Message') !!}

{!! Form::close() !!}
```
