<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed $title
 * @property mixed $slug
 * @property mixed $id
 */
class BlogCategory extends Model
{
    use SoftDeletes;
    use HasFactory;

    const ROOT = 1;

    protected $fillable = ['title',
                           'slug',
                           'parent_id',
                           'description',];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentCategory(){
        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }

    /**
     * @return string
     */
    public function getParentTitleAttribute(){
        $title = $this->parentCategory->title
            ?? ($this->isRoot()
            ? 'Корень'
            : '???');

        return $title;
    }

    /**
     * @return bool
     */
    private function isRoot()
    {
        return $this->id === BlogCategory::ROOT;
    }
}


