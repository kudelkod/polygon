<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;

class BlogPostObserver
{
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

    protected function setBlogPostSlug($blogPost){

        if(empty($blogPost->slug)){
            $blogPost->slug= str_slug($blogPost->title);
        }
    }

    protected function setBlogPostPublishedAt($blogPost){

        if(empty($blogPost->published_at) && $blogPost->is_published){
            $blogPost->published_at=Carbon::now();
        }
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
