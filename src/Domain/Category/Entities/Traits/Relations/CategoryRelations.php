<?php

namespace Src\Domain\Category\Entities\Traits\Relations;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\MorphedByMany;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Src\Domain\Product\Entities\Product;

trait CategoryRelations
{
    public function products(): HasMany
    {
        return $this->hasMany(Product::class , 'category_id','id');

    }

    public function medias()
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function logo()
    {
        return $this->medias()->where('collection_name','logos');
    }

    public function images()
    {
        return $this->medias()->where('collection_name','images');
    }
}
