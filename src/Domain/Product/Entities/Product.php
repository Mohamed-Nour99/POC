<?php

namespace Src\Domain\Product\Entities;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Src\Infrastructure\AbstractModels\BaseModel as Model;
use Src\Domain\Product\Entities\Traits\Relations\ProductRelations;
use Src\Domain\Product\Entities\Traits\CustomAttributes\ProductAttributes;
use Src\Domain\Product\Repositories\Contracts\ProductRepository;

class Product extends Model implements HasMedia
{
    use ProductRelations, ProductAttributes , InteractsWithMedia , HasTranslations;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Product';

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
        'category_id'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "products";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = ProductRepository::class;

    public $translatable = ['name'];

    public function scopeHideCategoryId($query)
    {
        return $query->makeHidden('category_id');
    }

    protected $builder = ProductBuilder::class;

}
