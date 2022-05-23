<?php

namespace Igorsgm\Ghost\Models\Resources;

use Igorsgm\Ghost\Interfaces\ResourceInterface;
use Igorsgm\Ghost\Models\Seo;
use Illuminate\Support\Collection;

class Post extends BaseResource implements ResourceInterface
{
    protected string $resourceName = 'posts';

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
    public $uuid;

    /**
     * @var string|null
     */
    public $title;

    /**
     * @var string|null
     */
    public $mobiledoc;

    /**
     * @var string|null
     */
    public $html;

    /**
     * @var string|null
     */
    public $commentId;

    /**
     * @var string|null
     */
    public $featureImage;

    /**
     * @var string|null
     */
    public $featureImageAlt;

    /**
     * @var string|null
     */
    public $featureImageCaption;

    /**
     * @var string|null
     */
    public $featured;

    /**
     * @var string|null
     */
    public $visibility;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var string|null
     */
    public $updatedAt;

    /**
     * @var string|null
     */
    public $publishedAt;

    /**
     * @var string|null
     */
    public $customExcerpt;

    /**
     * @var string|null
     */
    public $codeinjectionHead;

    /**
     * @var string|null
     */
    public $codeinjectionFoot;

    /**
     * @var string|null
     */
    public $customTemplate;

    /**
     * @var string|null
     */
    public $emailRecipientFilter;

    /**
     * @var string|null
     */
    public $url;

    /**
     * @var string|null
     */
    public $excerpt;

    /**
     * @var string|null
     */
    public $readingTime;

    /**
     * @var string|null
     */
    public $access;

    /**
     * @var string|null
     */
    public $emailSubject;

    /**
     * @var boolean
     */
    public $emailOnly;

    /**
     * @var Collection|null
     */
    public $authors;

    /**
     * @var Author|null
     */
    public $primaryAuthor;

    /**
     * @var Collection|null
     */
    public $tags;

    /**
     * @var Tag|null
     */
    public $primaryTag;

    /**
     * @var Seo
     */
    public $seo;

    /**
     * @param  array  $array
     * @return Post
     */
    public static function createFromArray($array): Post
    {
        $post = new self();

        $post->slug = $array['slug'] ?? null;
        $post->id = $array['id'] ?? null;
        $post->uuid = $array['uuid'] ?? null;
        $post->title = $array['title'] ?? null;
        $post->mobiledoc = $array['mobiledoc'] ?? null;
        $post->html = $array['html'] ?? null;
        $post->commentId = $array['comment_id'] ?? null;
        $post->featureImage = $array['feature_image'] ?? null;
        $post->featureImageAlt = $array['feature_image_alt'] ?? null;
        $post->featureImageCaption = $array['feature_image_caption'] ?? null;
        $post->featured = $array['featured'] ?? false;
        $post->visibility = $array['visibility'] ?? 'public';

        $post->createdAt = $array['created_at'] ?? null;
        $post->updatedAt = $array['updated_at'] ?? null;
        $post->publishedAt = $array['published_at'] ?? null;

        $post->customExcerpt = $array['custom_excerpt'] ?? null;
        $post->codeinjectionHead = $array['codeinjection_head'] ?? null;
        $post->codeinjectionFoot = $array['codeinjection_foot'] ?? null;
        $post->customTemplate = $array['custom_template'] ?? null;
        $post->emailRecipientFilter = $array['email_recipient_filter'] ?? 'none';
        $post->excerpt = $array['excerpt'] ?? null;
        $post->readingTime = $array['reading_time'] ?? null;
        $post->access = $array['access'] ?? false;

        $post->url = $array['url'] ?? null;
        $post->seo = Seo::createFromArray($array);

        $post->emailOnly = $array['email_only'] ?? false;
        $post->emailSubject = $array['email_subject'] ?? null;

        $post->authors = collect(data_get($array, 'authors'))->map(function ($author) {
            return Author::createFromArray($author);
        });
        $post->primaryAuthor = !empty($array['primary_author']) ? Author::createFromArray($array['primary_author']) : null;

        $post->tags = collect(data_get($array, 'tags'))->map(function ($tag) {
            return Tag::createFromArray($tag);
        });
        $post->primaryTag = !empty($array['primary_tag']) ? Tag::createFromArray($array['primary_tag']) : null;

        return $post;
    }
}
