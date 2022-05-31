<?php

namespace Igorsgm\Ghost\Models;

class Benefit extends BaseModel
{
    /**
     * @var string|null
     */
    public $id;

    /**
     * @var string|null
     */
    public $name;

    /**
     * @var string|null
     */
    public $slug;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var string|null
     */
    public $updatedAt;

    /**
     * @param  array  $array
     * @return Benefit
     */
    public static function createFromArray($array): Benefit
    {
        return parent::fill(new self(), $array);
    }
}
