<?php

namespace Src\Domain\Product\Http\Resources\Product;

use Illuminate\Http\Request;
use Src\Domain\Category\Http\Resources\Category\CategoryResource;
use Src\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request):array
    {
        return [
            $this->attributes(['id', 'name', 'category_id']),

            // 'id'               => $this->id,
            // 'name'             => $this->name,
            // 'category_id'      => $this->category_id,
            // 'image'            => $this->when($request->has('image') ||$request->has('include')      || empty($request->all()), $this->getFirstMediaUrl('images')),
             'category'         => CategoryResource::make($this->whenLoaded('category')),
        ];
    }
}
