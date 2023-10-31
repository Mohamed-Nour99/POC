<?php

namespace Src\Domain\Product\Http\Controllers;

use Src\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Src\Domain\Product\Http\Requests\Product\ProductStoreFormRequest;
use Src\Domain\Product\Http\Requests\Product\ProductUpdateFormRequest;
use Src\Domain\Product\Repositories\Contracts\ProductRepository;
use Illuminate\Http\Request;
use theaddresstech\DDD\Traits\Responder;
use Src\Domain\Product\Entities\Product;
use Src\Domain\Product\Http\Resources\Product\ProductResourceCollection;
use Src\Domain\Product\Http\Resources\Product\ProductResource;

class ProductController extends Controller
{
    use Responder;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'product';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'products';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'products';


    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->productRepository->spatie()->paginate(1);

        $this->setData('title', __('main.show-all') . ' ' . __('main.product'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(ProductResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.product'), 'web');

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
    public function store(ProductStoreFormRequest $request)
    {
        $store = $this->productRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);
            $store->addMediaFromRequest('image')->toMediaCollection('images');
            
            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(ProductResource::class, 'data');
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
    public function show(Product $product)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.product') . ' : ' . $product->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('show', $product);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(ProductResource::class,'show');

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.product') . ' : ' . $product->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('edit', $product);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(ProductResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateFormRequest $request, $product)
    {
        $update = $this->productRepository->update($request->validated(), $product);

        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(ProductResource::class, 'data');
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

        $delete = $this->productRepository->destroy($ids);

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
