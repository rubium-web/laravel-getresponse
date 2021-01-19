<?php

namespace Rubium\Getresponse;

use Illuminate\Support\Facades\Facade;

class GetresponseFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-getresponse';
    }
}
