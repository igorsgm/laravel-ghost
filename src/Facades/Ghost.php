<?php

namespace Igorsgm\Ghost\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Igorsgm\lGhost\Skeleton\SkeletonClass
 */
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
