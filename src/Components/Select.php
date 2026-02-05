<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Select extends FormComponent
{
    public $name;
    public $list;
    public $selected;
    public $selectAttributes;
    public $optionsAttributes;
    public $optgroupsAttributes;
    public $label;

    public function __construct(
        FormBuilder $form,
        $name,
        $list = [],
        $selected = null,
        $selectAttributes = [],
        $optionsAttributes = [],
        $optgroupsAttributes = [],
        $label = null
    ) {
        parent::__construct($form);
        $this->name = $name;
        $this->list = $list;
        $this->selected = $selected;
        $this->selectAttributes = $selectAttributes;
        $this->optionsAttributes = $optionsAttributes;
        $this->optgroupsAttributes = $optgroupsAttributes;
        $this->label = $label;
    }

    public function render()
    {
        return function (array $data) {
            $html = '';
            if ($this->label) {
                $html .= $this->form->label($this->name, $this->label);
            }
            $html .= $this->form->select(
                $this->name,
                $this->list,
                $this->selected,
                $this->selectAttributes,
                $this->optionsAttributes,
                $this->optgroupsAttributes
            );
            $html .= $this->getErrorHtml($data, $this->name);
            return $html;
        };
    }
}
