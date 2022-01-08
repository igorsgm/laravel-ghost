<?php

namespace Igorsgm\Ghost\Models;

use Illuminate\Support\Collection;

class Post
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
    public $uuid;

    /**
     * @var string|null
     */
    public $title;

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
    public $canonicalUrl;

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
    public $ogImage;

    /**
     * @var string|null
     */
    public $ogTitle;

    /**
     * @var string|null
     */
    public $ogDescription;

    /**
     * @var string|null
     */
    public $twitterImage;

    /**
     * @var string|null
     */
    public $twitterTitle;

    /**
     * @var string|null
     */
    public $twitterDescription;

    /**
     * @var string|null
     */
    public $metaTitle;

    /**
     * @var string|null
     */
    public $metaDescription;

    /**
     * @var string|null
     */
    public $emailSubject;

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
        $post->html = $array['html'] ?? null;
        $post->commentId = $array['comment_id'] ?? null;
        $post->featureImage = $array['feature_image'] ?? null;
        $post->featureImageAlt = $array['feature_image_alt'] ?? null;
        $post->featureImageCaption = $array['feature_image_caption'] ?? null;
        $post->featured = $array['featured'] ?? null;
        $post->visibility = $array['visibility'] ?? null;
        $post->createdAt = $array['created_at'] ?? null;
        $post->updatedAt = $array['updated_at'] ?? null;
        $post->publishedAt = $array['published_at'] ?? null;
        $post->customExcerpt = $array['custom_excerpt'] ?? null;
        $post->codeinjectionHead = $array['codeinjection_head'] ?? null;
        $post->codeinjectionFoot = $array['codeinjection_foot'] ?? null;
        $post->customTemplate = $array['custom_template'] ?? null;
        $post->canonicalUrl = $array['canonical_url'] ?? null;
        $post->emailRecipientFilter = $array['email_recipient_filter'] ?? null;
        $post->url = $array['url'] ?? null;
        $post->excerpt = $array['excerpt'] ?? null;
        $post->readingTime = $array['reading_time'] ?? null;
        $post->access = $array['access'] ?? null;
        $post->ogImage = $array['og_image'] ?? null;
        $post->ogTitle = $array['og_title'] ?? null;
        $post->ogDescription = $array['og_description'] ?? null;
        $post->twitterImage = $array['twitter_image'] ?? null;
        $post->twitterTitle = $array['twitter_title'] ?? null;
        $post->twitterDescription = $array['twitter_description'] ?? null;
        $post->metaTitle = $array['meta_title'] ?? null;
        $post->metaDescription = $array['meta_description'] ?? null;
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

    public function getResourceName()
    {
        return 'posts';
    }
}
