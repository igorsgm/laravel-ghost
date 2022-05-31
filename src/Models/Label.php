<?php

namespace Igorsgm\Ghost\Models;

class Label extends BaseModel
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
     * @return Label
     */
    public static function createFromArray($array): Label
    {
        return parent::fill(new self(), $array);
    }
}
