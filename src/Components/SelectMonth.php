<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class SelectMonth extends FormComponent
{
    public $name;
    public $selected;
    public $options;
    public $format;
    public $label;

    public function __construct(FormBuilder $form, $name, $selected = null, $options = [], $format = 'F', $label = null)
    {
        parent::__construct($form);
        $this->name = $name;
        $this->selected = $selected;
        $this->options = $options;
        $this->format = $format;
        $this->label = $label;
    }

    public function render()
    {
        return function (array $data) {
            $html = '';
            if ($this->label) {
                $html .= $this->form->label($this->name, $this->label);
            }
            $html .= $this->form->selectMonth($this->name, $this->selected, $this->options, $this->format);
            return $html;
        };
    }
}
