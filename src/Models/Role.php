<?php

namespace Igorsgm\Ghost\Models;

class Role extends BaseModel
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
    public $description;

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
     * @return Role
     */
    public static function createFromArray($array): Role
    {
        return parent::fill(new self(), $array);
    }
}
