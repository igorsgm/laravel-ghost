<?php

namespace Igorsgm\Ghost\Interfaces;

interface ResourceInterface
{
    public function getResourceName();

    public static function createFromArray($array);
}
