<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class SelectRange extends FormComponent
{
    public $name;
    public $begin;
    public $end;
    public $selected;
    public $options;
    public $label;

    public function __construct(FormBuilder $form, $name, $begin, $end, $selected = null, $options = [], $label = null)
    {
        parent::__construct($form);
        $this->name = $name;
        $this->begin = $begin;
        $this->end = $end;
        $this->selected = $selected;
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
            $html .= $this->form->selectRange($this->name, $this->begin, $this->end, $this->selected, $this->options);
            return $html;
        };
    }
}
