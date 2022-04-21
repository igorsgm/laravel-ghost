<?php

namespace Igorsgm\Ghost\Facades;

use Illuminate\Support\Facades\Facade;

class Ghost extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-ghost';
    }
}
