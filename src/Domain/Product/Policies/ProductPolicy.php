<?php

namespace Src\Domain\Product\Policies;

use Src\Domain\Product\Entities\Product;
use Src\Domain\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Src\Domain\User\Entities\User  $user
     * @param  \Src\Domain\User\Entities\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Src\Domain\User\Entities\User  $user
     * @param  \Src\Domain\Product\Entities\Product  $product
     * @return mixed
     */
    public function view(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Src\Domain\User\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Src\Domain\User\Entities\User  $user
     * @param  \Src\Domain\Product\Entities\Product  $product
     * @return mixed
     */
    public function update(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Src\Domain\User\Entities\User  $user
     * @param  \Src\Domain\Product\Entities\Product  $product
     * @return mixed
     */
    public function delete(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Src\Domain\User\Entities\User  $user
     * @param  \Src\Domain\Product\Entities\Product  $product
     * @return mixed
     */
    public function restore(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Src\Domain\User\Entities\User  $user
     * @param  \Src\Domain\Product\Entities\Product  $product
     * @return mixed
     */
    public function forceDelete(User $user, Product $product)
    {
        //
    }
}
