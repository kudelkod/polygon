<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['namespace'=>'App\Http\Controllers\Blog', 'prefix'=>'blog'],

    function (){
        Route::resource('posts', 'PostController')->names('blog.posts');
    }
);

$groupData = [
    'namespace'=>'App\Http\Controllers\Blog\Admin',
    'prefix'=>'admin/blog',
];

//Админка
Route::group($groupData, function (){
    $methods = ['index', 'edit','update', 'create', 'store'];
    Route::resource('categories', 'CategoryController')
        ->only($methods)
        ->names('blog.admin.categories');

    Route::resource('posts', 'PostController')
        ->except('show')
        ->names('blog.admin.posts');
});



Auth::routes();

Route::group(['prefix' => 'digging_deeper', 'namespace' => 'App\Http\Controllers',], function (){
    Route::get('collections', 'DiggingDeeperController@collections')
        ->name('digging_deeper.collections');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
