<?php

namespace Skywalker\Html\Components;

use Skywalker\Html\FormBuilder;

class Close extends FormComponent
{
    public function render()
    {
        return function (array $data) {
            return $this->form->close();
        };
    }
}
