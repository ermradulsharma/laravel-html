# API Reference

Complete method reference for FormBuilder and HtmlBuilder.

## FormBuilder

### Form Methods

#### `open(array $options = [])`

Open a form.

```php
Form::open(['url' => 'users/store'])
Form::open(['route' => 'users.store'])
Form::open(['action' => 'UserController@store'])
Form::open(['method' => 'PUT'])
Form::open(['files' => true]) // For file uploads
```

#### `model($model, array $options = [])`

Open a form with model binding.

```php
Form::model($user, ['route' => ['users.update', $user->id]])
```

#### `close()`

Close the form.

```php
Form::close()
```

### Basic Inputs

#### `text($name, $value = null, $options = [])`

#### `email($name, $value = null, $options = [])`

#### `password($name, $options = [])`

#### `url($name, $value = null, $options = [])`

#### `tel($name, $value = null, $options = [])`

#### `number($name, $value = null, $options = [])`

#### `date($name, $value = null, $options = [])`

#### `time($name, $value = null, $options = [])`

#### `hidden($name, $value = null, $options = [])`

### Textarea & Select

#### `textarea($name, $value = null, $options = [])`

```php
Form::textarea('bio', null, ['rows' => 5])
```

#### `select($name, $list = [], $selected = null, $options = [])`

```php
Form::select('country', ['US' => 'United States', 'UK' => 'United Kingdom'])
Form::select('role', UserRole::class) // Enum support
```

### Checkboxes & Radios

#### `checkbox($name, $value = 1, $checked = false, $options = [])`

```php
Form::checkbox('agree', 1, true)
```

#### `radio($name, $value, $checked = false, $options = [])`

```php
Form::radio('gender', 'male', true)
```

### Smart Inputs (Phase 5)

#### `rules($rules)`

Set HTML5 validation rules.

```php
Form::rules('required|email|max:255')->text('email')
```

#### `toggle($name, $value = 1, $checked = false, $options = [])`

iOS-style toggle switch.

```php
Form::toggle('notifications', 1, true, ['label' => 'Enable'])
```

#### `colorPicker($name, $value = null, $options = [])`

Color input.

```php
Form::colorPicker('brand_color', '#3490dc')
```

### Advanced Selects (Phase 6)

#### `searchableSelect($name, $list = [], $selected = null, $options = [])`

Searchable dropdown with datalist.

```php
Form::searchableSelect('country', $countries, 'US')
```

#### `multiSelect($name, $list = [], $selected = [], $options = [])`

Multiple selection.

```php
Form::multiSelect('tags', $tags, ['php', 'js'])
```

#### `ajaxSelect($name, $url, $selected = null, $options = [])`

AJAX-powered select.

```php
Form::ajaxSelect('user_id', '/api/users', $userId)
```

#### `autocomplete($name, $source, $value = null, $options = [])`

Autocomplete input.

```php
Form::autocomplete('city', ['New York', 'Los Angeles'])
Form::autocomplete('city', '/api/cities/search') // AJAX
```

### Date/Time & Files (Phase 7)

#### `datePicker($name, $value = null, $options = [])`

#### `timePicker($name, $value = null, $options = [])`

#### `dateRangePicker($startName, $endName, $startValue = null, $endValue = null, $options = [])`

```php
Form::datePicker('birthday', '1990-01-01')
Form::timePicker('appointment', '14:30')
Form::dateRangePicker('start_date', 'end_date')
```

#### `fileUpload($name, $options = [])`

File upload with preview.

```php
Form::fileUpload('avatar', ['accept' => 'image/*', 'preview' => true])
```

#### `multipleFiles($name, $options = [])`

Multiple file upload.

```php
Form::multipleFiles('documents', ['max' => 5, 'accept' => '.pdf'])
```

### Rich Content (Phase 8)

#### `richText($name, $value = null, $options = [])`

Rich text editor.

```php
Form::richText('content', $value, ['toolbar' => 'full'])
```

#### `inlineEdit($name, $value = null, $updateUrl = null, $options = [])`

Inline editing.

```php
Form::inlineEdit('title', $post->title, route('posts.update', $post))
```

#### `wizard($steps, $options = [])`

Multi-step form wizard.

```php
Form::wizard([
    'Step 1' => [],
    'Step 2' => [],
    'Step 3' => []
])
```

### Livewire Helpers (Phase 4)

#### `wire($name)`

#### `wireLazy($name)`

#### `wireDefer($name)`

#### `wireLive($name, $debounce = null)`

#### `wireClick($method)`

#### `wireSubmit($method)`

#### `wireSubmitPrevent($method)`

```php
Form::wire('email')->text('email')
Form::wireLive('search', 300)->text('search')
Form::wireClick('save')->submit('Save')
```

### Buttons

#### `submit($value = 'Submit', $options = [])`

#### `button($value = 'Button', $options = [])`

#### `reset($value = 'Reset', $options = [])`

### Labels

#### `label($name, $value = null, $options = [])`

```php
Form::label('email', 'Email Address')
```

---

## HtmlBuilder

### Utilities (Phase 2)

#### `breadcrumbs($items, $options = [])`

```php
Html::breadcrumbs(['Home' => '/', 'Products' => '/products', 'Details' => null])
```

#### `gravatar($email, $size = 80, $default = 'mp', $rating = 'g', $options = [])`

```php
Html::gravatar('user@example.com', 120)
```

#### `activeClass($routeName, $activeClass = 'active', $inactiveClass = '')`

```php
Html::activeClass('home')
Html::activeClass(['products.*', 'shop.*'])
```

### UI Components (Phase 3)

#### `alert($message, $type = 'info', $options = [], $dismissible = false)`

```php
Html::alert('Success!', 'success', [], true)
```

#### `card($title = null, $body = null, $footer = null, $options = [])`

```php
Html::card('Title', 'Body content', 'Footer')
```

#### `modal($id, $title, $body, $footer = null, $options = [])`

```php
Html::modal('myModal', 'Title', 'Content', '<button>Close</button>')
```

### UI Components (Phase 9)

#### `rating($name, $max = 5, $value = 0, $options = [])`

```php
Html::rating('product', 5, 4.5, ['readonly' => true])
```

#### `progressBar($percentage, $options = [])`

```php
Html::progressBar(75, ['striped' => true, 'animated' => true])
```

#### `badge($text, $variant = 'primary', $options = [])`

#### `pill($text, $variant = 'primary', $options = [])`

```php
Html::badge('New', 'primary')
Html::pill('Admin', 'success')
```

#### `tabs($tabs, $options = [])`

```php
Html::tabs(['Tab 1' => 'Content 1', 'Tab 2' => 'Content 2'])
```

#### `accordion($items, $options = [])`

```php
Html::accordion(['Section 1' => 'Content 1', 'Section 2' => 'Content 2'])
```

#### `tooltip($content, $tooltip, $options = [])`

```php
Html::tooltip('Hover me', 'Tooltip text', ['position' => 'top'])
```

#### `popover($trigger, $title, $content, $options = [])`

```php
Html::popover('Click me', 'Title', 'Content')
```

### Basic HTML

#### `link($url, $title = null, $attributes = [])`

#### `image($url, $alt = null, $attributes = [])`

#### `script($url, $attributes = [])`

#### `style($url, $attributes = [])`

---

## Next Steps

- [Examples](Examples.md) - Real-world usage examples
- [Smart Inputs](Smart-Inputs.md) - Advanced input features
- [UI Components](UI-Components.md) - Complete UI library
