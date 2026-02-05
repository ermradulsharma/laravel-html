<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Open extends FormComponent
{
    public $model;
    public $options;

    public function __construct(FormBuilder $form, $model = null, $options = [])
    {
        parent::__construct($form);
        $this->model = $model;
        $this->options = $options;
    }

    public function render()
    {
        return function (array $data) {
            if ($this->model) {
                return $this->form->model($this->model, $this->options);
            }

            return $this->form->open($this->options);
        };
    }
}
