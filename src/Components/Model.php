<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Model extends FormComponent
{
    public $model;
    public $options;

    public function __construct(FormBuilder $form, $model, $options = [])
    {
        parent::__construct($form);
        $this->model = $model;
        $this->options = $options;
    }

    public function render()
    {
        return function (array $data) {
            return $this->form->model($this->model, $this->options);
        };
    }
}
