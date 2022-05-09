<?php

namespace Igorsgm\Ghost\Models;

use Igorsgm\Ghost\Models\Resources\Tag;

class Meta
{
    /**
     * @var
     */
    public $pagination;

    /**
     * @param  array  $array
     * @return Tag
     */
    public static function createFromArray($array): Meta
    {
        $meta = new Meta();

        $meta->pagination = (object) $array['pagination'];

        return $meta;
    }

    /**
     * @return int|null
     */
    public function page()
    {
        return $this->pagination->page ?? null;
    }

    /**
     * @return int|null
     */
    public function limit()
    {
        return $this->pagination->limit ?? null;
    }

    /**
     * @return int|null
     */
    public function pages()
    {
        return $this->pagination->pages ?? null;
    }

    /**
     * @return int|null
     */
    public function total()
    {
        return $this->pagination->total ?? null;
    }

    /**
     * @return bool
     */
    public function hasNext()
    {
        return !empty($this->pagination->next);
    }

    /**
     * @return int|null
     */
    public function next()
    {
        return $this->pagination->next ?? null;
    }

    /**
     * @return bool
     */
    public function hasPrev()
    {
        return !empty($this->pagination->prev);
    }

    /**
     * @return int|null
     */
    public function prev()
    {
        return $this->pagination->prev ?? null;
    }
}
