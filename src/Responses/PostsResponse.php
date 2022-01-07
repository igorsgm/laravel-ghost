<?php

namespace Igorsgm\Ghost\Responses;

use Igorsgm\Ghost\Models\Author;
use Igorsgm\Ghost\Models\Post;
use Igorsgm\Ghost\Models\Tag;

class PostsResponse
{
    public function __construct(array $responsePosts)
    {
        $posts = collect();
        foreach ($responsePosts as $post) {
            $posts->push(Post::createFromArray($post));
        }

        $posts = $posts;

    }
}
