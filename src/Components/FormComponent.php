<?php

namespace Skywalker\Html\Components;

use Illuminate\View\Component;
use Skywalker\Html\FormBuilder;

class FormComponent extends Component
{
    /**
     * The form builder instance.
     *
     * @var \Skywalker\Html\FormBuilder
     */
    protected $form;

    /**
     * Create a new component instance.
     *
     * @param  \Skywalker\Html\FormBuilder $form
     */
    public function __construct(FormBuilder $form)
    {
        $this->form = $form;
    }

    /**
     * Get the error HTML for the given field.
     *
     * @param  array  $data
     * @param  string $name
     * @return string
     */
    protected function getErrorHtml(array $data, string $name): string
    {
        $session = $this->form->getSessionStore();
        $errors = $data['errors'] ?? ($session ? $session->get('errors') : null);

        if ($errors && $errors->has($name)) {
            $class = $this->form->getHtmlBuilder()->getThemeClass('error') ?? 'text-red-500 text-xs mt-1';
            return '<div class="' . $class . '">' . $errors->first($name) . '</div>';
        }

        return '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return '';
    }
}
