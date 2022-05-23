<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Models\Role;
use Igorsgm\Ghost\Models\Seo;
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
        $user = self::fill($user, $array);

        return $user;
    }

    protected static function fill($user, array $array)
    {
        $user->id = $array['id'] ?? null;
        $user->name = $array['name'] ?? null;
        $user->slug = $array['slug'] ?? null;
        $user->email = $array['email'] ?? null;
        $user->profileImage = $array['profile_image'] ?? null;
        $user->coverImage = $array['cover_image'] ?? null;
        $user->bio = $array['bio'] ?? null;
        $user->website = $array['website'] ?? null;
        $user->location = $array['location'] ?? null;
        $user->facebook = $array['facebook'] ?? null;
        $user->twitter = $array['twitter'] ?? null;
        $user->accessibility = $array['accessibility'] ?? null;
        $user->tour = $array['tour'] ?? null;
        $user->lastSeen = $array['last_seen'] ?? null;

        $user->createdAt = $array['created_at'] ?? null;
        $user->updatedAt = $array['updated_at'] ?? null;

        $user->url = $array['url'] ?? null;

        $user->seo = Seo::createFromArray($array);
        $user->roles = collect(data_get($array, 'roles'))->map(function ($role) {
            return Role::createFromArray($role);
        });

        $user->postsCount = data_get($array, 'count.posts');

        return $user;
    }
}
