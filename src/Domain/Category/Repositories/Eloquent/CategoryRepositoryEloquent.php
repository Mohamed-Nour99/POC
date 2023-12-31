<?php

namespace Src\Domain\Category\Repositories\Eloquent;

use Src\Domain\Category\Repositories\Contracts\CategoryRepository;
use Src\Domain\Category\Entities\Category;
use Src\Domain\Product\Entities\Product;
use Src\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CategoryRepositoryEloquent extends EloquentRepository implements CategoryRepository
{

    /**
     * Specify Fields
     *
     * @return string
     */
    protected $allowedFields = [
        'id',
        'name',
        'products.category_id',
        'products.id',
        'products.name',
        

    ];

    /**
     * Include Relationships
     *
     * @return string
     */
    protected $allowedIncludes = [
       'products',
       'medias',
       'logo',
       'images',
       'media'
       
    ];

    protected $allowedFilterScopes = [
    ];


    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    /**
     * Specify Model Relationships
     *
     * @return string
     */
    public function relations()
    {
        return [

        ];
    }
}
