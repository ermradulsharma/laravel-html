<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Button extends FormComponent
{
    public $value;
    public $options;

    public function __construct(FormBuilder $form, $value = null, $options = [])
    {
        parent::__construct($form);
        $this->value = $value;
        $this->options = $options;
    }

    public function render()
    {
        return function (array $data) {
            return $this->form->button($this->value, $this->options);
        };
    }
}
