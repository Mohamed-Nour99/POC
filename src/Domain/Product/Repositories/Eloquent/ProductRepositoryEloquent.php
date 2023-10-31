<?php

namespace Src\Domain\Product\Repositories\Eloquent;

use Src\Domain\Product\Repositories\Contracts\ProductRepository;
use Src\Domain\Product\Entities\Product;
use Src\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class ProductRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductRepositoryEloquent extends EloquentRepository implements ProductRepository
{

    /**
     * Specify Fields
     *
     * @return string
     */
    protected $allowedFields = [
       'id',
       'name',
       'category.id',
       'category.name',
    ];

    /**
     * Include Relationships
     *
     * @return string
     */
    protected $allowedIncludes = [
        'category'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    /**
     * Specify Model Relationships
     *
     * @return string
     */
    public function relations()
    {
        return [
            ###allowedRelations###
            ###\allowedRelations###
        ];
    }
}
