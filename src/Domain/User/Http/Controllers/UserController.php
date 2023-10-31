<?php

namespace Src\Domain\User\Http\Controllers;

use Src\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Src\Domain\User\Http\Requests\User\UserStoreFormRequest;
use Src\Domain\User\Http\Requests\User\UserUpdateFormRequest;
use Src\Domain\User\Repositories\Contracts\UserRepository;
use Illuminate\Http\Request;
use theaddresstech\DDD\Traits\Responder;
use Src\Domain\User\Entities\User;
use Src\Domain\User\Http\Resources\User\UserResourceCollection;
use Src\Domain\User\Http\Resources\User\UserResource;

class UserController extends Controller
{
    use Responder;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'user';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'users';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'users';


    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->userRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.user'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(UserResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.user'), 'web');

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
    public function store(UserStoreFormRequest $request)
    {
        $store = $this->userRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(UserResource::class, 'data');
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
    public function show(User $user)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.user') . ' : ' . $user->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('show', $user);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(UserResource::class,'show');

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.user') . ' : ' . $user->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('edit', $user);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(UserResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateFormRequest $request, $user)
    {
        $update = $this->userRepository->update($request->validated(), $user);

        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(UserResource::class, 'data');
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

        $delete = $this->userRepository->destroy($ids);

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
