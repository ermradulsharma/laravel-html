<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Checkbox extends FormComponent
{
    public $name;
    public $value;
    public $checked;
    public $options;
    public $label;

    public function __construct(FormBuilder $form, $name, $value = 1, $checked = null, $options = [], $label = null)
    {
        parent::__construct($form);
        $this->name = $name;
        $this->value = $value;
        $this->checked = $checked;
        $this->options = $options;
        $this->label = $label;
    }

    public function render()
    {
        return function (array $data) {
            $html = '';
            $html .= $this->form->checkbox($this->name, $this->value, $this->checked, $this->options);
            if ($this->label) {
                $html .= $this->form->label($this->name, $this->label);
            }
            $html .= $this->getErrorHtml($data, $this->name);
            return $html;
        };
    }
}
