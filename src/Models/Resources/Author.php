<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Models\Role;
use Igorsgm\Ghost\Models\Seo;
use Illuminate\Support\Collection;

class Author implements ResourceInterface
{
    /**
     * @var string|null
     */
    public $id;

    /**
     * @var string|null
     */
    public $slug;

    /**
     * @var string|null
     */
    public $name;

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
     * @return Author
     */
    public static function createFromArray($array): Author
    {
        $author = new self();

        $author->id = $array['id'] ?? null;
        $author->name = $array['name'] ?? null;
        $author->slug = $array['slug'] ?? null;
        $author->email = $array['email'] ?? null;
        $author->profileImage = $array['profile_image'] ?? null;
        $author->coverImage = $array['cover_image'] ?? null;
        $author->bio = $array['bio'] ?? null;
        $author->website = $array['website'] ?? null;
        $author->location = $array['location'] ?? null;
        $author->facebook = $array['facebook'] ?? null;
        $author->twitter = $array['twitter'] ?? null;
        $author->accessibility = $array['accessibility'] ?? null;
        $author->tour = $array['tour'] ?? null;
        $author->lastSeen = $array['last_seen'] ?? null;

        $author->createdAt = $array['created_at'] ?? null;
        $author->updatedAt = $array['updated_at'] ?? null;

        $author->url = $array['url'] ?? null;

        $author->seo = Seo::createFromArray($array);
        $author->roles = collect(data_get($array, 'roles'))->map(function ($role) {
            return Role::createFromArray($role);
        });
        $author->postsCount = data_get($array, 'count.posts');

        return $author;
    }

    public function getResourceName()
    {
        return 'authors';
    }
}
