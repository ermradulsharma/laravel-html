<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Reset extends FormComponent
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
            return $this->form->reset($this->value, $this->options);
        };
    }
}
