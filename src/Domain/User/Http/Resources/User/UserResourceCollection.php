<?php

namespace Src\Domain\User\Http\Resources\User;

use Src\Infrastructure\Http\AbstractResources\BaseCollection as ResourceCollection;

use Illuminate\Http\Request;

class UserResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request) : array
    {
        // don't use $this->collection, but $this->toArray($request)

        return parent::toArray($request);
    }

}
