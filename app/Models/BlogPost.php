<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Carbon|mixed $published_at
 * @property mixed $title
 * @property mixed $is_published
 * @property mixed $slug
 * @property mixed $content_row
 * @property mixed $content_html
 * @property int|mixed|string $user_id
 * @method static find(int $id)
 */
class BlogPost extends Model
{
    use SoftDeletes;
    use HasFactory;

    const UNKNOWN_USER = 1;

    /**
     * @var string[]
     */
    protected $fillable
    =   [
            'title',
            'slug',
            'category_id',
            'excerpt',
            'content_row',
            'is_published',
            'published_at',
        ];

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

//    protected $dates = [
//      'published_at'
//    ];
}
