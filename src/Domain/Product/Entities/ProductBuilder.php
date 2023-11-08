<?php

namespace Src\Domain\Product\Entities;

use Illuminate\Database\Eloquent\Builder;

class ProductBuilder extends Builder
{
    public function excludeCategoryId()
    {
        return $this->select($this->getModel()->getTable() . '.*')
            ->addSelect(['id', 'name']);
    }
}