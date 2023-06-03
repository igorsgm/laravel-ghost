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
     */
    private array $dates = [
        'createdAt',
        'updatedAt',
        'publishedAt',
    ];

    /**
     * @var Seo
     */
    protected $seo;

    public function __construct(array $data = [])
    {
        if (! empty($data)) {
            $this->fill($data);
        }
    }

    /**
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
            $this->{$property} = $this->getCastedValue($property, $value) ?? null;
        }

        if (! empty($seoProperties)) {
            $this->seo = new Seo($seoProperties);
        }
    }

    /**
     * Fill a model property with a collection of models, when $property is inside $modelCollectionProperties keys
     *
     * @param  string  $property
     * @param  mixed  $value
     * @return \Illuminate\Support\Collection
     */
    private function castModelCollectionProperty($property, $value)
    {
        $propertyModel = $this->modelCollectionProperties[$property];

        return collect($value)->map(function ($item) use (&$propertyModel) {
            return new $propertyModel($item);
        });
    }

    /**
     * Fill a model property with a specific model, when $property is inside $modelProperties keys
     *
     * @param  string  $property
     * @param  mixed  $value
     * @return BaseModel|null
     */
    private function castModelProperty($property, $value)
    {
        $propertyModel = $this->modelProperties[$property];

        return ! empty($value) ? new $propertyModel($value) : null;
    }

    /**
     * @param  string|array  $value
     * @return Carbon|BaseModel|\Illuminate\Support\Collection|mixed|null
     */
    private function getCastedValue(string $property, $value)
    {
        if (array_key_exists($property, $this->modelCollectionProperties)) {
            $value = $this->castModelCollectionProperty($property, $value);
        }

        if (array_key_exists($property, $this->modelProperties)) {
            $value = $this->castModelProperty($property, $value);
        }

        if (in_array($property, $this->dates)) {
            $value = Carbon::parse($value);
        }

        return $value;
    }
}
