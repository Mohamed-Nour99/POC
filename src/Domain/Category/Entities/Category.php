<?php

namespace Src\Domain\Category\Entities;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
use Src\Infrastructure\AbstractModels\BaseModel as Model;
use Src\Domain\Category\Entities\Traits\Relations\CategoryRelations;
use Src\Domain\Category\Entities\Traits\CustomAttributes\CategoryAttributes;
use Src\Domain\Category\Repositories\Contracts\CategoryRepository;
use Src\Domain\Product\Entities\Product;

class Category extends Model implements HasMedia
{
    use CategoryRelations, CategoryAttributes , InteractsWithMedia , HasTranslations;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Category';

    /**
     * define belongsTo relations.
     *
     * @var array
     */
    private $belongsTo = [];

    /**
     * define hasMany relations.
     *
     * @var array
     */
    private $hasMany = [];

    /**
     * define belongsToMany relations.
     *
     * @var array
     */
    private $belongsToMany = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "categories";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = CategoryRepository::class;

    public $translatable = ['name'];


    public function scopeFilterByImageType($query , $type)
    {
        
            $media = $this->getFirstMedia($type);
    
            if ($media) {
                return $media->getUrl();
            }
    
            return null;
        
    }

    protected $appends = ['category_id'];

    public function getCategoryIdAttribute()
    {
        return $this->products->pluck('category_id')->first();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
