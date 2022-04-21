<?php

namespace Igorsgm\Ghost\Models;

class Role
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
        $role = new self();

        $role->id = $array['id'] ?? null;
        $role->name = $array['name'] ?? null;
        $role->createdAt = $array['created_at'] ?? null;
        $role->updatedAt = $array['updated_at'] ?? null;

        return $role;
    }
}
