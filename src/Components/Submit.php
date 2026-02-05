<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Submit extends FormComponent
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
            return $this->form->submit($this->value, $this->options);
        };
    }
}
