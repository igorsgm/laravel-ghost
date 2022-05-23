<?php

namespace Igorsgm\Ghost\Models;

class Price
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
        $price = new self();

        $price->id = $array['id'] ?? null;
        $price->active = $array['active'] ?? false;
        $price->nickname = $array['nickname'] ?? null;
        $price->description = $array['description'] ?? null;
        $price->currency = $array['currency'] ?? null;
        $price->amount = $array['amount'] ?? null;
        $price->type = $array['type'] ?? null;
        $price->interval = $array['interval'] ?? null;

        $price->createdAt = $array['created_at'] ?? null;
        $price->updatedAt = $array['updated_at'] ?? null;

        return $price;
    }
}
