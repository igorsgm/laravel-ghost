<?php

namespace Igorsgm\Ghost\Models;

class Navigation extends BaseModel
{
    /**
     * @var string|null
     */
    public $label;

    /**
     * @var string|null
     */
    public $url;

    /**
     * @param  array  $array
     * @return Navigation
     */
    public static function createFromArray($array): Navigation
    {
        return parent::fill(new self(), $array);
    }
}
