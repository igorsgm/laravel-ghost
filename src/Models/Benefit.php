<?php

namespace Igorsgm\Ghost\Models;

class Benefit
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
     * @return Role
     */
    public static function createFromArray($array): Benefit
    {
        $benefit = new self();

        $benefit->id = $array['id'] ?? null;
        $benefit->name = $array['name'] ?? null;
        $benefit->slug = $array['slug'] ?? null;
        $benefit->createdAt = $array['created_at'] ?? null;
        $benefit->updatedAt = $array['updated_at'] ?? null;

        return $benefit;
    }
}
