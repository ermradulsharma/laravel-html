<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Token extends FormComponent
{
    public function render()
    {
        return function (array $data) {
            return $this->form->token();
        };
    }
}
