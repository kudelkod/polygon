<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Models\BlogPost;
use App\Repositories\BlogPostRepository;
use App\Repositories\BlogCategoryRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends BaseController
{

    /**
     * @var BlogPostRepository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $blogPostRepository;

    /**
     * @var BlogCategoryRepository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $blogCategoryRepository;


    public function __construct()
    {
        parent::__construct();

        $this->blogPostRepository = app(BlogPostRepository::class);
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return
     * \Illuminate\Contracts\Foundation\Application
     * \Illuminate\Contracts\View\Factory
     * \Illuminate\Contracts\View\View
     * \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator=$this->blogPostRepository->getAllWithPaginate();

        return view('blog.admin.posts.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogPost();
        $categoryList = $this->blogCategoryRepository->getForCombobox();

        return view('blog.admin.posts.edit',
        compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();

        $item = (new BlogPost())->create($data);

        if($item){
            return redirect()->route('blog.admin.posts.edit', [$item->id])
                             ->with(['success' => 'Успешно сохранено']);
        }
        else{
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                         ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return
     * \Illuminate\Contracts\Foundation\Application
     * \Illuminate\Contracts\View\Factory|
     * \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if(empty($item)){
            abort(404);
        }

        $categoryList = $this->blogCategoryRepository->getForCombobox();

        return view('blog.admin.posts.edit',
            compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if(empty($item)){
            return back()
                ->withErrors(['msg' => "Запись id={$id} не найдена"])
                ->withInput();
        }

        $data = $request->all();

//////////////////////// Ушло в обсервер
//        if(empty($data['slug'])){
//            $data['slug']= str_slug($data['title']);
//        }
//
//        if(empty($item->published_at) && $data['is_published']){
//            $data['published_at']=Carbon::now();
//        }
//////////////////////////////////////////////////
        $result = $item->update($data);

        if ($result){
            return redirect()
                ->route('blog.admin.posts.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        }
        else{
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // софт-удаление (без базы)
        $result = BlogPost::destroy($id);

        // удаление из базы
//        $result = BlogPost::find($id)->forceDelete();

        if($result){
            return redirect()->route('blog.admin.posts.index')
                ->with(['success' => "Запись $id была успешно удалена"]);
        }
        else{
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
