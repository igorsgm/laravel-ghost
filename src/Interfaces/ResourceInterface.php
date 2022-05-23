<?php

namespace Igorsgm\Ghost\Interfaces;

/**
 * @property string $resourceName;
 */
interface ResourceInterface
{
    public function getResourceName();

    public static function createFromArray($array);
}
