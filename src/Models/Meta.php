<?php

namespace Igorsgm\Ghost\Models;

class Meta extends BaseModel
{
    /**
     * @var array
     */
    public $pagination;

    /**
     * @param  array  $data
     */
    public function __construct(array $data = [])
    {
        $this->pagination = (object) ($data['pagination'] ?? []);
    }

    /**
     * @return int
     */
    public function page()
    {
        return $this->pagination->page ?? null;
    }

    /**
     * @return int
     */
    public function limit()
    {
        return $this->pagination->limit ?? null;
    }

    /**
     * @return int
     */
    public function pages()
    {
        return $this->pagination->pages ?? null;
    }

    /**
     * @return int
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
     * @return int
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
     * @return int
     */
    public function prev()
    {
        return $this->pagination->prev ?? null;
    }
}
