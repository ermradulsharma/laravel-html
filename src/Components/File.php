<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class File extends FormComponent
{
    public $name;
    public $options;
    public $label;

    public function __construct(FormBuilder $form, $name, $options = [], $label = null)
    {
        parent::__construct($form);
        $this->name = $name;
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
            $html .= $this->form->file($this->name, $this->options);
            return $html;
        };
    }
}
