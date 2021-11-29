<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\AbstractList;

class DiggingDeeperController extends Controller
{
    public function collections(){

        $result = [];

        $eloquentCollection = BlogPost::withTrashed()->get();

        //dd(__METHOD__, $eloquentCollection, $eloquentCollection->toArray());

        $collection = collect($eloquentCollection->toArray());

//        dd(
//            get_class($eloquentCollection),
//            get_class($collection),
//            $collection
//        );

//        $result['first'] = $collection->first();
//        $result['last'] = $collection->last();
//
        $result['where']['data'] = $collection
            ->where('category_id',10)
            ->values()
            ->keyBy('id');
//
//        dd($result);

//        $result['where']['count'] = $result['where']['data']->count();
//        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
//        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();

//        dd($result);

//        $result['where_first'] = $collection -> firstWhere('created_at','>', '2019-01-17 01:35:11');

//        dd($result);

        //Базовая переменная не изменится, просто вернется измененная версия
//        $result['map']['all'] = $collection->map(function (array $item){
//            $newItem = new \stdClass();
//            $newItem->item_id = $item['id'];
//            $newItem->item_name = $item['title'];
//            $newItem->exists = is_null($item['deleted_at']);
//
//            return $newItem;
//        });
//
//        $result['map']['not_exists'] = $result['map']['all']
//            ->where('exists', '=', false)
//            ->values()
//            ->keyBy('item_id');

//        dd($result);

        // Базовая переменная трансформируется(изменится)
            $collection->transform(function (array $item){
               $newItem = new \stdClass();
               $newItem->item_id = $item['id'];
               $newItem->item_name = $item['title'];
               $newItem->exists = is_null($item['deleted_at']);
               $newItem->created_at = Carbon::parse($item['created_at']);

               return $newItem;
            });

//        dd($collection);
//
//        $newItem = new \stdClass();
//        $newItem->id = 9999;
//
//        $newItem2 = new \stdClass();
//        $newItem2->id = 8888;

//        dd($newItem, $newItem2);

        // Установить элемент в начало коллекции
//        $newItemFirst = $collection->prepend($newItem)->first();// добавляет в начало
//        $newItemLast = $collection->push($newItem2)->last();// добавляет в конец
//        $pulledItem = $collection->pull(1);// забирает элемент (не копию) по ключу
//
//        dd(compact('collection', 'newItemFirst', 'newItemLast', 'pulledItem'));

        // Фильтрация (замена orWhere())
//        $filtered = $collection->filter(function ($item){
//           $byDay = $item->created_at->isFriday();
//           $byDate = $item->created_at->day == 8;
//
//           $result = $byDate && $byDay;
//
//           return $result;
//        });
//
//        dd(compact('filtered'));

        // Сортировка коллекции
        $sortedSimpleCollection = collect([5,1,3,2,4])->sort();// по возрастанию
        $sortedAscCollection = $collection->sortBy('created_at');// по возрастанию
        $sortedDescCollection = $collection->sortByDesc('item_id');// по убыванию

        dd(compact('sortedSimpleCollection', 'sortedAscCollection', 'sortedDescCollection'));
    }
}
