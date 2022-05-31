<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;

class Theme extends BaseResource implements ResourceInterface
{
    protected string $resourceName = 'themes';

    /**
     * @var mixed|null
     */
    public $name;

    /**
     * @var mixed|null
     */
    public $package;

    /**
     * @var boolean
     */
    public $active;

    /**
     * @var array
     */
    public $templates;

    /**
     * @param  array  $array
     * @return Theme
     */
    public static function createFromArray($array): Theme
    {
        return parent::fill(new self(), $array);
    }
}
