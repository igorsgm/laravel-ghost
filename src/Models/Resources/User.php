<?php

namespace Igorsgm\Ghost\Models\Resources;

/**
 * Class User
 *
 * @property-read string $id
 * @property-read string $name
 * @property-read string $slug
 * @property-read string $email
 * @property-read string $profileImage
 * @property-read string $coverImage
 * @property-read string $bio
 * @property-read string $website
 * @property-read string $location
 * @property-read string $facebook
 * @property-read string $twitter
 * @property-read string $accessibility
 * @property-read string $tour
 * @property-read string $lastSeen
 * @property-read string $url
 * @property-read string $createdAt
 * @property-read string $updatedAt
 * @property-read \Illuminate\Support\Collection $roles
 * @property-read int $postsCount
 */
class User extends BaseResource
{
    protected string $resourceName = 'users';

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->postsCount = data_get($data, 'count.posts');
    }
}
