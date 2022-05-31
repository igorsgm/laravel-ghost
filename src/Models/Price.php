<?php

namespace Igorsgm\Ghost\Models;

class Price extends BaseModel
{
    /**
     * @var mixed|null
     */
    public $id;

    /**
     * @var boolean
     */
    public $active;

    /**
     * @var string|null
     */
    public $nickname;

    /**
     * @var string|null
     */
    public $description;

    /**
     * @var string|null
     */
    public $currency;

    /**
     * @var string|integer|null
     */
    public $amount;

    /**
     * @var string|null
     */
    public $type;

    /**
     * @var string|null
     */
    public $interval;

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
     * @return Price
     */
    public static function createFromArray($array): Price
    {
        return parent::fill(new self(), $array);
    }
}
