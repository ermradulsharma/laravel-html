<?php

namespace Skywalker\Html;

use BadMethodCallException;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Routing\UrlGenerator;

class HtmlBuilder
{
    use Macroable, Componentable {
        Macroable::__call as macroCall;
        Componentable::__call as componentCall;
    }

    /**
     * The URL generator instance.
     *
     * @var \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected $url;

    /**
     * The active CSS framework theme.
     *
     * @var string|null
     */
    protected $theme = null;

    /**
     * The theme-specific class mappings.
     *
     * @var array
     */
    protected $themeClasses = [
        'tailwind' => [
            'input' => 'border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none block w-full',
            'checkbox' => 'rounded border-gray-300 text-blue-600 focus:ring-blue-500',
            'radio' => 'text-blue-600 focus:ring-blue-500',
            'select' => 'border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none block w-full',
            'textarea' => 'border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none block w-full',
            'submit' => 'bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition',
            'button' => 'bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded transition',
            'label' => 'block text-gray-700 text-sm font-bold mb-2',
        ],
        'bootstrap' => [
            'input' => 'form-control',
            'checkbox' => 'form-check-input',
            'radio' => 'form-check-input',
            'select' => 'form-select',
            'textarea' => 'form-control',
            'submit' => 'btn btn-primary',
            'button' => 'btn btn-secondary',
            'label' => 'form-label',
        ],
    ];

    /**
     * The View Factory instance.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;

    /**
     * Create a new HTML builder instance.
     *
     * @param \Illuminate\Contracts\Routing\UrlGenerator $url
     * @param \Illuminate\Contracts\View\Factory         $view
     */
    public function __construct(?UrlGenerator $url = null, Factory $view)
    {
        $this->url = $url;
        $this->view = $view;

        if (function_exists('config')) {
            $this->theme = \config('html.theme', null);
            $this->themeClasses = array_merge($this->themeClasses, \config('html.themes', []));
        }
    }

    /**
     * Set the active CSS framework theme.
     *
     * @param  string|null $theme
     *
     * @return $this
     */
    public function theme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get the classes for a specific element type based on the active theme.
     *
     * @param  string $type
     *
     * @return string|null
     */
    public function getThemeClass(string $type): ?string
    {
        if (is_null($this->theme) || ! isset($this->themeClasses[$this->theme])) {
            return null;
        }

        $classes = $this->themeClasses[$this->theme];

        if (isset($classes[$type])) {
            return $classes[$type];
        }

        // Fallback for common input types
        $inputTypes = [
            'text',
            'email',
            'password',
            'url',
            'tel',
            'number',
            'date',
            'datetime',
            'datetime-local',
            'month',
            'time',
            'week',
            'search'
        ];

        if (in_array($type, $inputTypes) && isset($classes['input'])) {
            return $classes['input'];
        }

        return null;
    }

    /**
     * Convert an HTML string to entities.
     *
     * @param string $value
     *
     * @return string
     */
    public function entities(string $value): string
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
    }

    /**
     * Convert entities to HTML characters.
     *
     * @param string $value
     *
     * @return string
     */
    public function decode(string $value): string
    {
        return html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Generate a link to a JavaScript file.
     *
     * @param string $url
     * @param array  $attributes
     * @param bool   $secure
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function script(string $url, array $attributes = [], ?bool $secure = null): HtmlString
    {
        $attributes['src'] = $this->url->asset($url, $secure);

        return $this->toHtmlString('<script' . $this->attributes($attributes) . '></script>');
    }

    /**
     * Generate a link to a CSS file.
     *
     * @param string $url
     * @param array  $attributes
     * @param bool   $secure
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function style(string $url, array $attributes = [], ?bool $secure = null): HtmlString
    {
        $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];

        $attributes = array_merge($defaults, $attributes);

        $attributes['href'] = $this->url->asset($url, $secure);

        return $this->toHtmlString('<link' . $this->attributes($attributes) . '>');
    }

    /**
     * Generate an HTML image element.
     *
     * @param string $url
     * @param string $alt
     * @param array  $attributes
     * @param bool   $secure
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function image(string $url, ?string $alt = null, array $attributes = [], ?bool $secure = null): HtmlString
    {
        $attributes['alt'] = $alt;

        return $this->toHtmlString('<img src="' . $this->url->asset(
            $url,
            $secure
        ) . '"' . $this->attributes($attributes) . '>');
    }

    /**
     * Generate a link to a Favicon file.
     *
     * @param string $url
     * @param array  $attributes
     * @param bool   $secure
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function favicon(string $url, array $attributes = [], ?bool $secure = null): HtmlString
    {
        $defaults = ['rel' => 'shortcut icon', 'type' => 'image/x-icon'];

        $attributes = array_merge($defaults, $attributes);

        $attributes['href'] = $this->url->asset($url, $secure);

        return $this->toHtmlString('<link' . $this->attributes($attributes) . '>');
    }

    /**
     * Generate a HTML link.
     *
     * @param string $url
     * @param string $title
     * @param array  $attributes
     * @param bool   $secure
     * @param bool   $escape
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function link(string $url, ?string $title = null, array $attributes = [], ?bool $secure = null, bool $escape = true): HtmlString
    {
        $url = $this->url->to($url, [], $secure);

        if (is_null($title) || $title === false) {
            $title = $url;
        }

        if ($escape) {
            $title = $this->entities($title);
        }

        return $this->toHtmlString('<a href="' . $this->entities($url) . '"' . $this->attributes($attributes) . '>' . $title . '</a>');
    }

    /**
     * Generate a HTTPS HTML link.
     *
     * @param string $url
     * @param string $title
     * @param array  $attributes
     * @param bool   $escape
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function secureLink(string $url, ?string $title = null, array $attributes = [], bool $escape = true): HtmlString
    {
        return $this->link($url, $title, $attributes, true, $escape);
    }

    /**
     * Generate a HTML link to an asset.
     *
     * @param string $url
     * @param string $title
     * @param array  $attributes
     * @param bool   $secure
     * @param bool   $escape
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function linkAsset(string $url, ?string $title = null, array $attributes = [], ?bool $secure = null, bool $escape = true): HtmlString
    {
        $url = $this->url->asset($url, $secure);

        return $this->link($url, $title ?: $url, $attributes, $secure, $escape);
    }

    /**
     * Generate a HTTPS HTML link to an asset.
     *
     * @param string $url
     * @param string $title
     * @param array  $attributes
     * @param bool   $escape
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function linkSecureAsset(string $url, ?string $title = null, array $attributes = [], bool $escape = true): HtmlString
    {
        return $this->linkAsset($url, $title, $attributes, true, $escape);
    }

    /**
     * Generate a HTML link to a named route.
     *
     * @param string $name
     * @param string $title
     * @param array  $parameters
     * @param array  $attributes
     * @param bool   $secure
     * @param bool   $escape
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function linkRoute(string $name, ?string $title = null, array $parameters = [], array $attributes = [], ?bool $secure = null, bool $escape = true): HtmlString
    {
        return $this->link($this->url->route($name, $parameters), $title, $attributes, $secure, $escape);
    }

    /**
     * Generate a HTML link to a controller action.
     *
     * @param string $action
     * @param string $title
     * @param array  $parameters
     * @param array  $attributes
     * @param bool   $secure
     * @param bool   $escape
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function linkAction(string $action, ?string $title = null, array $parameters = [], array $attributes = [], ?bool $secure = null, bool $escape = true): HtmlString
    {
        return $this->link($this->url->action($action, $parameters), $title, $attributes, $secure, $escape);
    }


    /**
     * Generate a HTML link to an email address.
     *
     * @param string $email
     * @param string $title
     * @param array  $attributes
     * @param bool   $escape
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function mailto(string $email, ?string $title = null, array $attributes = [], bool $escape = true): HtmlString
    {
        $email = $this->email($email);

        $title = $title ?: $email;

        if ($escape) {
            $title = $this->entities($title);
        }

        $email = $this->obfuscate('mailto:') . $email;

        return $this->toHtmlString('<a href="' . $email . '"' . $this->attributes($attributes) . '>' . $title . '</a>');
    }
    /**
     * Obfuscate an e-mail address to prevent spam-bots from sniffing it.
     *
     * @param string $email
     *
     * @return string
     */
    public function email(string $email): string
    {
        return str_replace('@', '&#64;', $this->obfuscate($email));
    }

    /**
     * Generates non-breaking space entities based on number supplied.
     *
     * @param int $num
     *
     * @return string
     */
    public function nbsp(int $num = 1): string
    {
        return str_repeat('&nbsp;', $num);
    }

    /**
     * Generate an ordered list of items.
     *
     * @param array $list
     * @param array $attributes
     *
     * @return \Illuminate\Support\HtmlString|string
     */
    public function ol(array $list, array $attributes = [])
    {
        return $this->listing('ol', $list, $attributes);
    }

    /**
     * Generate an un-ordered list of items.
     *
     * @param array $list
     * @param array $attributes
     *
     * @return \Illuminate\Support\HtmlString|string
     */
    public function ul(array $list, array $attributes = [])
    {
        return $this->listing('ul', $list, $attributes);
    }

    /**
     * Generate a description list of items.
     *
     * @param array $list
     * @param array $attributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function dl(array $list, array $attributes = []): HtmlString
    {
        $attributes = $this->attributes($attributes);

        $html = "<dl{$attributes}>";

        foreach ($list as $key => $value) {
            $value = (array) $value;

            $html .= "<dt>$key</dt>";

            foreach ($value as $v_key => $v_value) {
                $html .= "<dd>$v_value</dd>";
            }
        }

        $html .= '</dl>';

        return $this->toHtmlString($html);
    }

    /**
     * Create a listing HTML element.
     *
     * @param string $type
     * @param array  $list
     * @param array  $attributes
     *
     * @return \Illuminate\Support\HtmlString|string
     */
    protected function listing(string $type, array $list, array $attributes = [])
    {
        $html = '';

        if (count($list) === 0) {
            return $html;
        }

        // Essentially we will just spin through the list and build the list of the HTML
        // elements from the array. We will also handled nested lists in case that is
        // present in the array. Then we will build out the final listing elements.
        foreach ($list as $key => $value) {
            $html .= $this->listingElement($key, $type, $value);
        }

        $attributes = $this->attributes($attributes);

        return $this->toHtmlString("<{$type}{$attributes}>{$html}</{$type}>");
    }

    /**
     * Create the HTML for a listing element.
     *
     * @param mixed  $key
     * @param string $type
     * @param mixed  $value
     *
     * @return string
     */
    protected function listingElement($key, string $type, $value): string
    {
        if (is_array($value)) {
            return $this->nestedListing($key, $type, $value);
        } else {
            return '<li>' . e($value, false) . '</li>';
        }
    }

    /**
     * Create the HTML for a nested listing attribute.
     *
     * @param mixed  $key
     * @param string $type
     * @param mixed  $value
     *
     * @return string
     */
    protected function nestedListing($key, string $type, $value): string
    {
        if (is_int($key)) {
            return $this->listing($type, $value);
        } else {
            return '<li>' . $key . $this->listing($type, $value) . '</li>';
        }
    }

    /**
     * Build an HTML attribute string from an array.
     *
     * @param array $attributes
     *
     * @return string
     */
    public function attributes(array $attributes): string
    {
        $html = [];

        foreach ((array) $attributes as $key => $value) {
            $element = $this->attributeElement($key, $value);

            if (! is_null($element)) {
                $html[] = $element;
            }
        }

        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }

    /**
     * Build a single attribute element.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return string|null
     */
    protected function attributeElement($key, $value): ?string
    {
        // For numeric keys we will assume that the value is a boolean attribute
        // where the presence of the attribute represents a true value and the
        // absence represents a false value.
        // This will convert HTML attributes such as "required" to a correct
        // form instead of using incorrect numerics.
        if (is_numeric($key)) {
            return $value;
        }

        // Treat boolean attributes as HTML properties
        if (is_bool($value) && $key !== 'value') {
            return $value ? (string) $key : '';
        }

        if (is_array($value) && $key === 'class') {
            return 'class="' . implode(' ', $value) . '"';
        }

        if (! is_null($value)) {
            return $key . '="' . e($value, false) . '"';
        }

        return null;
    }

    /**
     * Obfuscate a string to prevent spam-bots from sniffing it.
     *
     * @param string $value
     *
     * @return string
     */
    public function obfuscate(string $value): string
    {
        $safe = '';

        foreach (str_split($value) as $letter) {
            if (ord($letter) > 128) {
                return $letter;
            }

            // To properly obfuscate the value, we will randomly convert each letter to
            // its entity or hexadecimal representation, keeping a bot from sniffing
            // the randomly obfuscated letters out of the string on the responses.
            switch (rand(1, 3)) {
                case 1:
                    $safe .= '&#' . ord($letter) . ';';
                    break;

                case 2:
                    $safe .= '&#x' . dechex(ord($letter)) . ';';
                    break;

                case 3:
                    $safe .= $letter;
            }
        }

        return $safe;
    }

    /**
     * Generate a meta tag.
     *
     * @param string|null $name
     * @param string $content
     * @param array  $attributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function meta(?string $name, string $content, array $attributes = []): HtmlString
    {
        $defaults = compact('name', 'content');

        $attributes = array_merge($defaults, $attributes);

        return $this->toHtmlString('<meta' . $this->attributes($attributes) . '>');
    }

    /**
     * Generate an html tag.
     *
     * @param string $tag
     * @param mixed $content
     * @param array  $attributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function tag(string $tag, $content, array $attributes = []): HtmlString
    {
        $content = is_array($content) ? implode('', $content) : $content;
        return $this->toHtmlString('<' . $tag . $this->attributes($attributes) . '>' . $this->toHtmlString((string) $content) . '</' . $tag . '>');
    }

    /**
     * Transform the string to an Html serializable object
     *
     * @param string $html
     *
     * @return \Illuminate\Support\HtmlString
     */
    protected function toHtmlString(string $html): HtmlString
    {
        return new HtmlString($html);
    }

    /**
     * Generate breadcrumb navigation.
     *
     * @param  array $items Array of ['label' => 'Home', 'url' => '/'] or just ['Home' => '/']
     * @param  array $attributes
     * @return \Illuminate\Support\HtmlString
     */
    public function breadcrumbs(array $items, array $attributes = []): HtmlString
    {
        $theme = $this->getTheme();

        if ($theme === 'bootstrap') {
            $html = '<nav' . $this->attributes($attributes) . '>';
            $html .= '<ol class="breadcrumb">';

            $lastKey = array_key_last($items);
            foreach ($items as $key => $item) {
                $isLast = ($key === $lastKey);

                if (is_array($item)) {
                    $label = $item['label'] ?? $item[0] ?? '';
                    $url = $item['url'] ?? $item[1] ?? null;
                } else {
                    $label = $key;
                    $url = $item;
                }

                if ($isLast || is_null($url)) {
                    $html .= '<li class="breadcrumb-item active" aria-current="page">' . e($label) . '</li>';
                } else {
                    $html .= '<li class="breadcrumb-item"><a href="' . e($url) . '">' . e($label) . '</a></li>';
                }
            }

            $html .= '</ol></nav>';
        } elseif ($theme === 'tailwind') {
            $html = '<nav' . $this->attributes($attributes) . '>';
            $html .= '<ol class="flex items-center space-x-2 text-sm">';

            $lastKey = array_key_last($items);
            foreach ($items as $key => $item) {
                $isLast = ($key === $lastKey);

                if (is_array($item)) {
                    $label = $item['label'] ?? $item[0] ?? '';
                    $url = $item['url'] ?? $item[1] ?? null;
                } else {
                    $label = $key;
                    $url = $item;
                }

                if (!$isLast) {
                    $html .= '<li class="flex items-center">';
                    if (!is_null($url)) {
                        $html .= '<a href="' . e($url) . '" class="text-blue-600 hover:text-blue-800">' . e($label) . '</a>';
                    } else {
                        $html .= '<span class="text-gray-500">' . e($label) . '</span>';
                    }
                    $html .= '<svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>';
                    $html .= '</li>';
                } else {
                    $html .= '<li class="text-gray-700 font-medium">' . e($label) . '</li>';
                }
            }

            $html .= '</ol></nav>';
        } else {
            // Simple fallback
            $html = '<nav' . $this->attributes($attributes) . '>';
            $lastKey = array_key_last($items);
            $parts = [];

            foreach ($items as $key => $item) {
                $isLast = ($key === $lastKey);

                if (is_array($item)) {
                    $label = $item['label'] ?? $item[0] ?? '';
                    $url = $item['url'] ?? $item[1] ?? null;
                } else {
                    $label = $key;
                    $url = $item;
                }

                if ($isLast || is_null($url)) {
                    $parts[] = '<span>' . e($label) . '</span>';
                } else {
                    $parts[] = '<a href="' . e($url) . '">' . e($label) . '</a>';
                }
            }

            $html .= implode(' / ', $parts);
            $html .= '</nav>';
        }

        return $this->toHtmlString($html);
    }

    /**
     * Generate a Gravatar image URL or tag.
     *
     * @param  string $email
     * @param  int $size
     * @param  string $default
     * @param  string $rating
     * @param  array|null $attributes If provided, returns an img tag; otherwise returns URL
     * @return string|\Illuminate\Support\HtmlString
     */
    public function gravatar(string $email, int $size = 80, string $default = 'mp', string $rating = 'g', ?array $attributes = null)
    {
        $hash = md5(strtolower(trim($email)));
        $url = "https://www.gravatar.com/avatar/{$hash}?s={$size}&d={$default}&r={$rating}";

        if (is_null($attributes)) {
            return $url;
        }

        $attributes['src'] = $url;
        $attributes['alt'] = $attributes['alt'] ?? 'Avatar';

        return $this->toHtmlString('<img' . $this->attributes($attributes) . '>');
    }

    /**
     * Return an "active" class if the current route matches.
     *
     * @param  string|array $routes Route name(s) or URL pattern(s)
     * @param  string $activeClass
     * @param  string $inactiveClass
     * @return string
     */
    public function activeClass($routes, string $activeClass = 'active', string $inactiveClass = ''): string
    {
        $routes = (array) $routes;

        foreach ($routes as $route) {
            // Check if it's a route name
            if ($this->url && method_exists($this->url, 'current')) {
                $currentUrl = $this->url->current();

                // Try matching as route name
                if (function_exists('route') && function_exists('request')) {
                    try {
                        if (\request()->routeIs($route)) {
                            return $activeClass;
                        }
                    } catch (\Exception $e) {
                        // Route matching failed, continue
                    }
                }

                // Try matching as URL pattern
                if (strpos($currentUrl, $route) !== false || fnmatch($route, $currentUrl)) {
                    return $activeClass;
                }
            }
        }

        return $inactiveClass;
    }

    /**
     * Get the active theme.
     *
     * @return string|null
     */
    public function getTheme(): ?string
    {
        return $this->theme;
    }

    /**
     * Generate an alert component.
     *
     * @param  string $message
     * @param  string $type success|info|warning|danger
     * @param  array $attributes
     * @param  bool $dismissible
     * @return \Illuminate\Support\HtmlString
     */
    public function alert(string $message, string $type = 'info', array $attributes = [], bool $dismissible = false): HtmlString
    {
        $theme = $this->getTheme();

        if ($theme === 'bootstrap') {
            $class = "alert alert-{$type}";
            if ($dismissible) {
                $class .= ' alert-dismissible fade show';
            }

            $attributes['class'] = trim(($attributes['class'] ?? '') . ' ' . $class);
            $attributes['role'] = 'alert';

            $html = '<div' . $this->attributes($attributes) . '>';
            $html .= e($message, false);

            if ($dismissible) {
                $html .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            }

            $html .= '</div>';
        } elseif ($theme === 'tailwind') {
            $colorMap = [
                'success' => 'bg-green-100 border-green-400 text-green-700',
                'info' => 'bg-blue-100 border-blue-400 text-blue-700',
                'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
                'danger' => 'bg-red-100 border-red-400 text-red-700',
            ];

            $class = 'border px-4 py-3 rounded relative ' . ($colorMap[$type] ?? $colorMap['info']);
            $attributes['class'] = trim(($attributes['class'] ?? '') . ' ' . $class);
            $attributes['role'] = 'alert';

            $html = '<div' . $this->attributes($attributes) . '>';
            $html .= '<span class="block sm:inline">' . e($message, false) . '</span>';

            if ($dismissible) {
                $html .= '<span class="absolute top-0 bottom-0 right-0 px-4 py-3">';
                $html .= '<svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>';
                $html .= '</span>';
            }

            $html .= '</div>';
        } else {
            $html = '<div' . $this->attributes($attributes) . '>' . e($message, false) . '</div>';
        }

        return $this->toHtmlString($html);
    }

    /**
     * Generate a card component.
     *
     * @param  string|null $title
     * @param  string|null $body
     * @param  string|null $footer
     * @param  array $attributes
     * @return \Illuminate\Support\HtmlString
     */
    public function card(?string $title = null, ?string $body = null, ?string $footer = null, array $attributes = []): HtmlString
    {
        $theme = $this->getTheme();

        if ($theme === 'bootstrap') {
            $attributes['class'] = trim(($attributes['class'] ?? '') . ' card');

            $html = '<div' . $this->attributes($attributes) . '>';

            if ($title) {
                $html .= '<div class="card-header">' . e($title, false) . '</div>';
            }

            if ($body) {
                $html .= '<div class="card-body">' . e($body, false) . '</div>';
            }

            if ($footer) {
                $html .= '<div class="card-footer">' . e($footer, false) . '</div>';
            }

            $html .= '</div>';
        } elseif ($theme === 'tailwind') {
            $attributes['class'] = trim(($attributes['class'] ?? '') . ' bg-white shadow-md rounded-lg overflow-hidden');

            $html = '<div' . $this->attributes($attributes) . '>';

            if ($title) {
                $html .= '<div class="px-6 py-4 bg-gray-50 border-b border-gray-200">';
                $html .= '<h3 class="text-lg font-semibold text-gray-900">' . e($title, false) . '</h3>';
                $html .= '</div>';
            }

            if ($body) {
                $html .= '<div class="px-6 py-4">' . e($body, false) . '</div>';
            }

            if ($footer) {
                $html .= '<div class="px-6 py-4 bg-gray-50 border-t border-gray-200">' . e($footer, false) . '</div>';
            }

            $html .= '</div>';
        } else {
            $html = '<div' . $this->attributes($attributes) . '>';
            if ($title) $html .= '<div>' . e($title, false) . '</div>';
            if ($body) $html .= '<div>' . e($body, false) . '</div>';
            if ($footer) $html .= '<div>' . e($footer, false) . '</div>';
            $html .= '</div>';
        }

        return $this->toHtmlString($html);
    }

    /**
     * Generate a modal component.
     *
     * @param  string $id
     * @param  string|null $title
     * @param  string|null $body
     * @param  string|null $footer
     * @param  array $attributes
     * @return \Illuminate\Support\HtmlString
     */
    public function modal(string $id, ?string $title = null, ?string $body = null, ?string $footer = null, array $attributes = []): HtmlString
    {
        $theme = $this->getTheme();

        if ($theme === 'bootstrap') {
            $html = '<div class="modal fade" id="' . e($id) . '" tabindex="-1" aria-labelledby="' . e($id) . 'Label" aria-hidden="true">';
            $html .= '<div class="modal-dialog">';
            $html .= '<div class="modal-content">';

            if ($title) {
                $html .= '<div class="modal-header">';
                $html .= '<h5 class="modal-title" id="' . e($id) . 'Label">' . e($title, false) . '</h5>';
                $html .= '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                $html .= '</div>';
            }

            if ($body) {
                $html .= '<div class="modal-body">' . e($body, false) . '</div>';
            }

            if ($footer) {
                $html .= '<div class="modal-footer">' . e($footer, false) . '</div>';
            }

            $html .= '</div></div></div>';
        } elseif ($theme === 'tailwind') {
            $html = '<div id="' . e($id) . '" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">';
            $html .= '<div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">';
            $html .= '<div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>';
            $html .= '<span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>';
            $html .= '<div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">';

            if ($title) {
                $html .= '<div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">';
                $html .= '<h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">' . e($title, false) . '</h3>';
                $html .= '</div>';
            }

            if ($body) {
                $html .= '<div class="px-4 py-3 bg-gray-50 sm:px-6">' . e($body, false) . '</div>';
            }

            if ($footer) {
                $html .= '<div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">' . e($footer, false) . '</div>';
            }

            $html .= '</div></div></div>';
        } else {
            $html = '<div id="' . e($id) . '"' . $this->attributes($attributes) . '>';
            if ($title) $html .= '<div>' . e($title, false) . '</div>';
            if ($body) $html .= '<div>' . e($body, false) . '</div>';
            if ($footer) $html .= '<div>' . e($footer, false) . '</div>';
            $html .= '</div>';
        }

        return $this->toHtmlString($html);
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return \Illuminate\Contracts\View\View|mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (static::hasComponent($method)) {
            return $this->componentCall($method, $parameters);
        }

        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        throw new BadMethodCallException("Method {$method} does not exist.");
    }
}
