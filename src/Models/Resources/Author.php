<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;

class Author extends User implements ResourceInterface
{
    /**
     * @param  array  $array
     * @return Author
     */
    public static function createFromArray($array): Author
    {
        $author = new self();
        return $author::fill($author, $array);
    }

    public function getResourceName()
    {
        return 'authors';
    }
}
