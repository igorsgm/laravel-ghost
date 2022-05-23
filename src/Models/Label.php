<?php

namespace Igorsgm\Ghost\Models;

class Label
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
    public static function createFromArray($array): Label
    {
        $label = new self();

        $label->id = $array['id'] ?? null;
        $label->name = $array['name'] ?? null;
        $label->slug = $array['slug'] ?? null;
        $label->createdAt = $array['created_at'] ?? null;
        $label->updatedAt = $array['updated_at'] ?? null;

        return $label;
    }
}
