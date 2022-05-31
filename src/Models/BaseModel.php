<?php

namespace Igorsgm\Ghost\Models;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class BaseModel
{
    /**
     * @var array|string[]
     */
    protected static array $modelCollectionProperties = [
        'authors' => \Igorsgm\Ghost\Models\Resources\Author::class,
        'roles' => \Igorsgm\Ghost\Models\Role::class,
        'labels' => \Igorsgm\Ghost\Models\Label::class,
        'subscriptions' => \Igorsgm\Ghost\Models\Subscription::class,
        'tags' => \Igorsgm\Ghost\Models\Resources\Tag::class,
        'navigation' => \Igorsgm\Ghost\Models\Navigation::class,
        'benefits' => \Igorsgm\Ghost\Models\Benefit::class,
    ];

    /**
     * @var array|string[]
     */
    protected static array $modelProperties = [
        'seo' => \Igorsgm\Ghost\Models\Seo::class,
        'tier' => \Igorsgm\Ghost\Models\Resources\Tier::class,
        'primaryAuthor' => \Igorsgm\Ghost\Models\Resources\Author::class,
        'primaryTag' => \Igorsgm\Ghost\Models\Resources\Tag::class,
        'monthlyPrice' => \Igorsgm\Ghost\Models\Price::class,
        'yearlyPrice' => \Igorsgm\Ghost\Models\Price::class,
        'stripePrices' => \Igorsgm\Ghost\Models\Price::class,
        'price' => \Igorsgm\Ghost\Models\Price::class,
        'offer' => \Igorsgm\Ghost\Models\Resources\Offer::class,
    ];

    /**
     * @param  ResourceInterface|BaseModel  $model
     * @param  array  $array
     * @return mixed
     */
    public static function fill($model, $array)
    {
        $validProperties = get_object_vars($model);
        $validProperties = array_keys(Arr::except($validProperties, 'resourceName'));

        foreach ($validProperties as $property) {
            $arrayProperty = Str::snake($property);

            if (array_key_exists($property, self::$modelCollectionProperties)) {
                $propertyModel = self::$modelCollectionProperties[$property];

                $propertyData = collect(data_get($array, $arrayProperty));
                $model->{$property} = $propertyData->map(function ($item) use (&$propertyModel) {
                    return $propertyModel::createFromArray($item);
                });

                continue;
            }

            if (array_key_exists($property, self::$modelProperties)) {
                $propertyModel = self::$modelProperties[$property];
                $model->{$property} = !empty($array[$arrayProperty]) ? $propertyModel::createFromArray($array[$arrayProperty]) : null;
                continue;
            }

            $model->{$property} = $array[$arrayProperty] ?? null;
        }

        return $model;
    }
}
