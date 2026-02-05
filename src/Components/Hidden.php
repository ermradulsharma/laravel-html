<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Hidden extends FormComponent
{
    public $name;
    public $value;
    public $options;

    public function __construct(FormBuilder $form, $name, $value = null, $options = [])
    {
        parent::__construct($form);
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;
    }

    public function render()
    {
        return function (array $data) {
            return $this->form->hidden($this->name, $this->value, $this->options);
        };
    }
}
