<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Illuminate\Support\Collection;

class User extends BaseResource implements ResourceInterface
{
    protected string $resourceName = 'users';

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
    public $email;

    /**
     * @var string|null
     */
    public $profileImage;

    /**
     * @var string|null
     */
    public $coverImage;

    /**
     * @var string|null
     */
    public $bio;

    /**
     * @var string|null
     */
    public $website;

    /**
     * @var string|null
     */
    public $location;

    /**
     * @var string|null
     */
    public $facebook;

    /**
     * @var string|null
     */
    public $twitter;

    /**
     * @var string|null
     */
    public $accessibility;

    /**
     * @var string|null
     */
    public $tour;

    /**
     * @var string|null
     */
    public $lastSeen;

    /**
     * @var string|null
     */
    public $url;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var string|null
     */
    public $updatedAt;

    /**
     * @var Collection|null
     */
    public $roles;

    /**
     * @var integer
     */
    public $postsCount;

    /**
     * @param  array  $array
     * @return User
     */
    public static function createFromArray($array): User
    {
        $user = new self();
        $user = self::fillUser($user, $array);

        return $user;
    }

    /**
     * @param $user
     * @param  array  $array
     * @return ResourceInterface|\Igorsgm\Ghost\Models\BaseModel|mixed
     */
    protected static function fillUser($user, array $array)
    {
        $user = parent::fill($user, $array);
        $user->postsCount = data_get($array, 'count.posts');

        return $user;
    }
}
