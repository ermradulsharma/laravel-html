<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Image extends FormComponent
{
    public $url;
    public $name;
    public $value;
    public $options;

    public function __construct(FormBuilder $form, $url, $name = null, $value = null, $options = [])
    {
        parent::__construct($form);
        $this->url = $url;
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;
    }

    public function render()
    {
        return function (array $data) {
            return $this->form->image($this->url, $this->name, $this->value, $this->options);
        };
    }
}
