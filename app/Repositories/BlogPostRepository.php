<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\BlogPost as Model;

/**
 * Class BlogPostRepository.
 */
class BlogPostRepository extends CoreRepository
{
    protected function getModelClass()
    {
        // TODO: Implement getModelClass() method.
        return Model::class;
    }

    public function getAllWithPaginate(){

        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id'
            ];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->orderBy('id', 'DESC')
            //->with(['category', 'user'])
            ->with([//это отношения
                //можно так
                'category'=>function($query){
                $query->select(['id', 'title']);
            },
                //или так
            'user:id,name',
            ])
            ->paginate(25);

        return $result;
    }
    public function getEdit($id){
        return $this->startConditions()->find($id);
    }
}
