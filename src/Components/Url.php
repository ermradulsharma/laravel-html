<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Url extends FormComponent
{
    public $name;
    public $value;
    public $options;
    public $label;

    public function __construct(FormBuilder $form, $name, $value = null, $options = [], $label = null)
    {
        parent::__construct($form);
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;
        $this->label = $label;
    }

    public function render()
    {
        return function (array $data) {
            $html = '';
            if ($this->label) {
                $html .= $this->form->label($this->name, $this->label);
            }
            $html .= $this->form->url($this->name, $this->value, $this->options);
            return $html;
        };
    }
}
