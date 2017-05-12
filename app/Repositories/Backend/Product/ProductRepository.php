<?php

namespace App\Repositories\Backend\Product;

use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Events\Backend\Access\User\UserCreated;
use App\Events\Backend\Access\User\UserDeleted;
use App\Events\Backend\Access\User\UserUpdated;
use App\Events\Backend\Access\User\UserRestored;

use App\Events\Backend\Access\User\UserPermanentlyDeleted;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;

/**
 * Class ProductRepository.
 */
class ProductRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Product::class;

    /**
     * @param int  $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false)
    {
        /**
         * Note: You must return deleted_at or the User getActionButtonsAttribute won't
         * be able to differentiate what buttons to show for each row.
         */
        $dataTableQuery = $this->query()
            ->select([
                config('product.products_table').'.id',
                config('product.products_table').'.name',
                config('product.products_table').'.description',
                config('product.products_table').'.created_at',
                config('product.products_table').'.updated_at',
//                config('product.products_table').'.deleted_at',
            ]);

//        if ($trashed == 'true') {
//            return $dataTableQuery->onlyTrashed();
//        }

        // active() is a scope on the UserScope trait
//        return $dataTableQuery->active($status);
        return $dataTableQuery;
    }

    /**
     * @param array $input
     */
    public function create($input)
    {
        $data = $input['data'];
        $roles = $input['roles'];

        $user = $this->createProductStub($data);

        DB::transaction(function () use ($user, $data, $roles) {
            if ($user->save()) {
                //User Created, Validate Roles
                if (! count($roles['assignees_roles'])) {
                    throw new GeneralException(trans('exceptions.backend.access.users.role_needed_create'));
                }

                //Attach new roles
                $user->attachRoles($roles['assignees_roles']);

                //Send confirmation email if requested
                if (isset($data['confirmation_email']) && $user->confirmed == 0) {
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                }

                event(new UserCreated($user));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    /**
     * @param Model $user
     * @param array $input
     *
     * @return bool
     * @throws GeneralException
     */
    public function update(Model $user, array $input)
    {
        $data = $input['data'];
        $roles = $input['roles'];

        $this->checkUserByEmail($data, $user);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->status = isset($data['status']) ? 1 : 0;
        $user->confirmed = isset($data['confirmed']) ? 1 : 0;

        DB::transaction(function () use ($user, $data, $roles) {
            if ($user->save()) {
                $this->checkUserRolesCount($roles);
                $this->flushRoles($roles, $user);

                event(new UserUpdated($user));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.update_error'));
        });
    }


    /**
     * @param Model $user
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Model $user)
    {
        if (access()->id() == $user->id) {
            throw new GeneralException(trans('exceptions.backend.access.users.cant_delete_self'));
        }

        if ($user->id == 1) {
            throw new GeneralException(trans('exceptions.backend.access.users.cant_delete_admin'));
        }

        if ($user->delete()) {
            event(new UserDeleted($user));

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.delete_error'));
    }

    /**
     * @param Model $user
     *
     * @throws GeneralException
     */
    public function forceDelete(Model $user)
    {
        if (is_null($user->deleted_at)) {
            throw new GeneralException(trans('exceptions.backend.access.users.delete_first'));
        }

        DB::transaction(function () use ($user) {
            if ($user->forceDelete()) {
                event(new UserPermanentlyDeleted($user));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.delete_error'));
        });
    }

    /**
     * @param Model $user
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function restore(Model $user)
    {
        if (is_null($user->deleted_at)) {
            throw new GeneralException(trans('exceptions.backend.access.users.cant_restore'));
        }

        if ($user->restore()) {
            event(new UserRestored($user));

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.restore_error'));
    }

    /**
     * @param  $input
     *
     * @return mixed
     */
    protected function createProductStub($input)
    {
        $product = self::MODEL;
        $product = new $product;
        $product->name = $input['name'];
        $product->description = $input['description'];
        return $product;
    }
}
