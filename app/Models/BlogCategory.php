<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed $title
 * @property mixed $slug
 */
class BlogCategory extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['title',
                           'slug',
                           'parent_id',
                           'description',];
}
