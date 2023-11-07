<?php

namespace Src\Domain\Category\Http\Resources\Category;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Src\Domain\Product\Http\Resources\Product\ProductResource;
use Src\Domain\Product\Http\Resources\Product\ProductResourceCollection;
use Src\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class CategoryResource extends JsonResource
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

            $this->attributes(['id', 'name', 'media','deleted_at']),
            // 'id'               => $this->when($request->has('id')   || $request->has('include,id')  || empty($request->all()), $this->id),
            // // 'name_en'          => $this->name,
            // // 'name_ar'          => $this->name,   
            // 'name'             => $this->when($request->has('name')  || $request->has('include')&& $request->has('name')  || empty($request->all()), $this->name),
            // 'image'            => $this->when($request->has('image') || $request->has('include')&& $request->has('image') || empty($request->all()), $this->getFirstMediaUrl('images')),
            // 'image'            => $this->getFirstMediaUrl('images'),
            // 'logos'            => returnImages($this->getMedia('logos')),
            // 'products'         => $this->whenLoaded('products' , function() use ($request){
            //     return ProductResourceCollection::make($this->products()->Paginate($request->input('product_paginate')));
            // }), 
            'products'         => ProductResourceCollection::make($this->whenLoaded('products')),
            // 'product_count'    => $this->when(array_key_exists('product_count' , $request->all()) || array_key_exists('include' , $request->all()) || empty($request->all()), $this->products->count()),
            // 'id'   => $this->id,
            // 'name' => $this->name,
            // 'image'=> $this->getMedia('images')->first() ? $this->getMedia('images')->first()->getUrl() : null,

            // 'logo'      => $this->getMedia('logo')->first() ? $this->getMedia('logo')->first()->getUrl() : null,
            // 'image'            => $this->getFirstMediaUrl('images'),
            // 'products'         => ProductResourceCollection::make($this->whenLoaded('products')),
            // 'media'            => MediaCollection::make($this->whenLoaded('media')),
            

        ];
    }
}
