<?php

namespace Skywalker\Html;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Skywalker\Html\HtmlBuilder
 */
class HtmlFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'html';
    }
}
