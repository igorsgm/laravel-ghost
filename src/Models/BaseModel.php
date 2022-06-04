<?php

namespace Igorsgm\Ghost\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class BaseModel
{
    /**
     * @var array|string[]
     */
    private array $modelCollectionProperties = [
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
    private array $modelProperties = [
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
     * The attributes that should be mutated to Carbon dates.
     *
     * @var array
     */
    private array $dates = [
        'createdAt',
        'updatedAt',
        'publishedAt',
    ];

    /**
     * @param  array  $data
     */
    public function __construct(array $data = []) {
        if (!empty($data)) {
            $this->fill($data);
        }
    }

    /**
     * @param  array  $data
     * @return void
     */
    private function fill(array $data)
    {
        if (in_array(get_class($this), config('ghost.seo.models-with'))) {
            $seoProperties = Arr::only($data, config('ghost.seo.properties'));
            $data = Arr::except($data, config('ghost.seo.properties'));
        }

        foreach ($data as $key => $value) {
            $property = Str::camel($key);

            if (array_key_exists($property, $this->modelCollectionProperties)) {
                $propertyModel = $this->modelCollectionProperties[$property];

                $this->{$property} = collect($value)->map(function ($item) use (&$propertyModel) {
                    return new $propertyModel($item);
                });

                continue;
            }

            if (array_key_exists($property, $this->modelProperties)) {
                $propertyModel = $this->modelProperties[$property];
                $this->{$property} = !empty($value) ? new $propertyModel($value) : null;
                continue;
            }

            if (in_array($property, $this->dates)) {
                $value = Carbon::parse($value);
            }

            $this->{$property} = $value ?? null;
        }

        if (!empty($seoProperties)) {
            $this->seo = new Seo($seoProperties);
        }
    }
}
