<?php

namespace Src\Domain\Category\Http\Controllers;

use Src\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Src\Domain\Category\Http\Requests\Category\CategoryStoreFormRequest;
use Src\Domain\Category\Http\Requests\Category\CategoryUpdateFormRequest;
use Src\Domain\Category\Repositories\Contracts\CategoryRepository;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\QueryBuilder\QueryBuilder;
use theaddresstech\DDD\Traits\Responder;
use Src\Domain\Category\Entities\Category;
use Src\Domain\Category\Http\Resources\Category\CategoryResourceCollection;
use Src\Domain\Category\Http\Resources\Category\CategoryResource;

class CategoryController extends Controller
{
    use Responder;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'category';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'categories';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'categories';


    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function search($string)
    {
    $index = Category::search($string)->paginate(25);
    $this->setData('data', $index);
    $this->useCollection(CategoryResourceCollection::class, 'data');

    return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $columns = $request->input('columns'); // Default columns to include if not specified

        // $columns = explode(',', $columns);

    //     $index = QueryBuilder::for(Category::class)
    // ->allowedFields(['id', 'name','created_at'])
    // ->get();


    //     // dd($columns);
    // //     $category = Category::find(3);
    // //    $media =  $category->getMedia('images');
    //     // $index= Media::select('uuid')->first();
       
    // $index = Category::select($columns)->get();
    //        $media =  $index->getMedia('images');

    // // dd($index);
    // $category = new category();

    // // $index = QueryBuilder::for(Category::class)
    // // ->where('model_id', 1)
    // // ->where('model_type', Category::class)
    // // ->allowedFields('media.model_id', 'media.model_type')
    // // ->allowedIncludes('media');

    // $categories = Category::with('media')->get();


    // // dd($categories->getMediaFirstUrl());

    // // $images = collect();

    // foreach ($categories as $category) {
    //     $images = $category->getMedia('images');
    //     // dd($images);

    //     return response()->json($images->getUrl());

    // }

    // $category = Category::find(1);
    // $category->getMedia('images')->first()->getUrl('thumb');

    // if (!$category) {
    //     return response()->json(['message' => 'Category not found'], 404);
    // }

    // // Select the desired columns
    // $columns = $request->query('columns', '*'); // Default to all columns if 'columns' parameter is not provided
    // $selectedColumns = explode(',', $columns);

    

    // // Include image and logos if requested
    // if (in_array('image', $selectedColumns)) {
    //     $category->getFirstMediaUrl('images');
    // }

    // if (in_array('logos', $selectedColumns)) {
    //     $category->loadMedia('logos');
    // }

    // $category = $category->select($selectedColumns)->first();

    // return response()->json($category);

    //  $perPage = $request->input('per_page'); // Set your default per page value

    //     $index = Category::with('products')
    //         ->paginate($perPage);


    
        $index = $this->categoryRepository->spatie()->paginate();

        $this->setData('title', __('main.show-all') . ' ' . __('main.category'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(CategoryResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.category'), 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");

        $this->setApiResponse(fn()=> response()->json(['create_your_own_form'=>true]));

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreFormRequest $request)
    {
        $store = $this->categoryRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);
            $store->addMediaFromRequest('image')->toMediaCollection('images');
            $store->addMultipleMediaFromRequest(['logos'])->each( function ($fileadder){
                $fileadder->toMediaCollection('logos');});

            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(CategoryResource::class, 'data');
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=> response()->json(['created'=>false]));
        }

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.category') . ' : ' . $category->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('show', $category);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(CategoryResource::class,'show');

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.category') . ' : ' . $category->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('edit', $category);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(CategoryResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateFormRequest $request, $category)
    {
        $update = $this->categoryRepository->update($request->validated(), $category);

        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(CategoryResource::class, 'data');
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=>response()->json(['updated'=>false],422));
        }

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = request()->get('ids',[$id]);

        $delete = $this->categoryRepository->destroy($ids);

        if($delete){
            $this->redirectRoute("{$this->resourceRoute}.index");
            $this->setApiResponse(fn()=>response()->json(['deleted'=>true],200));
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=>response()->json(['updated'=>false],422));
        }

        return $this->response();
    }

}
