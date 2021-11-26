<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;

class BlogPostObserver
{
    protected function setBlogPostSlug(BlogPost $blogPost){

        if(empty($blogPost->slug)){
            $blogPost->slug= str_slug($blogPost->title);
        }
    }

    protected function setBlogPostPublishedAt(BlogPost $blogPost){

        if(empty($blogPost->published_at) && $blogPost->is_published){
            $blogPost->published_at=Carbon::now();
        }
    }

    protected function setBlogPostHtml(BlogPost $blogPost){
        if($blogPost->isDirty('content_row')){
            $blogPost->content_html = $blogPost->content_row;
        }
    }

    protected function setBlogPostUser(BlogPost $blogPost){

        $blogPost->user_id = auth()->id() ?? BlogPost::UNKNOWN_USER;
    }

    /**
     * Handle the BlogPost "created" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function created(BlogPost $blogPost)
    {
        //
    }

    public function creating(BlogPost $blogPost){

        $this->setBlogPostPublishedAt($blogPost);

        $this->setBlogPostSlug($blogPost);

        $this->setBlogPostHtml($blogPost);

        $this->setBlogPostUser($blogPost);
    }

    /**
     * Handle the BlogPost "updated" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function updated(BlogPost $blogPost)
    {
        //
    }

    public function updating(BlogPost $blogPost){

        $this->setBlogPostSlug($blogPost);
        $this->setBlogPostPublishedAt($blogPost);

    }

    /**
     * Handle the BlogPost "deleted" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the BlogPost "restored" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the BlogPost "force deleted" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        //
    }
}
