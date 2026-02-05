<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Input extends FormComponent
{
    public $type;
    public $name;
    public $value;
    public $options;
    public $label;
    public $floating;

    public function __construct(FormBuilder $form, $name, $type = 'text', $value = null, $options = [], $label = null, $floating = false)
    {
        parent::__construct($form);
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->options = $options;
        $this->label = $label;
        $this->floating = $floating;
    }

    public function render()
    {
        return function (array $data) {
            if ($this->floating) {
                $html = $this->form->floating($this->type, $this->name, $this->value, $this->options, $this->label);
            } else {
                $html = '';
                if ($this->label) {
                    $html .= $this->form->label($this->name, $this->label);
                }
                $html .= $this->form->input($this->type, $this->name, $this->value, $this->options);
            }

            $html .= $this->getErrorHtml($data, $this->name);
            return $html;
        };
    }
}
