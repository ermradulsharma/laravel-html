<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Label extends FormComponent
{
    public $name;
    public $value;
    public $options;
    public $escapeHtml;

    public function __construct(FormBuilder $form, $name, $value = null, $options = [], $escapeHtml = true)
    {
        parent::__construct($form);
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;
        $this->escapeHtml = $escapeHtml;
    }

    public function render()
    {
        return function (array $data) {
            return $this->form->label($this->name, $this->value, $this->options, $this->escapeHtml);
        };
    }
}
