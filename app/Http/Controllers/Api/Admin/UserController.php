<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\DeleteRequest;
use App\Http\Requests\Api\User\StoreRequest;
use App\Http\Requests\Api\User\UpdateRequest;
use App\Http\Requests\Api\User\DetailRequest;
use App\Http\Requests\Api\User\UpdateIsActiveRequest;
use App\Http\Requests\Api\User\UpdateIsShowRequest;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $user, $role;
    public function __construct()
    {
        $this->user = new User();
        $this->role = new Role();
    }
    /**
     * @OA\GET(
     *      path="/api/admin/user/listing",
     *      operationId="listing",
     *      tags={"admin,user,listing"},
     *      summary="user",
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      description="",
     *      @OA\Parameter(
     *          name="search",
     *          description="Search",
     *          required=false,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function listing(Request $request)
    {
        $inputs = $request->all();
        $query = $this->user->newQuery();
        if (!empty($inputs['search'])) {
            $query->where(function ($q) use ($inputs) {
                searchTable($q, $inputs['search'], ['name', 'email']);
                searchTable($q, $inputs['search'], ['name'], 'roles');
            });
        }
        $users = $query->with('roles')->orderBy('name', 'ASC')->paginate(PAGINATE);
        return successWithData(GENERAL_FETCHED_MESSAGE, $users);
    }

    /**
     * @OA\GET(
     *      path="/api/admin/user/detail",
     *      operationId="detail",
     *      tags={"admin,user,detail"},
     *      summary="user",
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      description="",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function detail(DetailRequest $request)
    {
        $inputs = $request->all();
        $user = $this->user->newQuery()
            ->with('roles')
            ->whereId($inputs['id'])->first();
        return successWithData(GENERAL_FETCHED_MESSAGE, $user);
    }

    /**
     * @OA\Post(
     *      path="/api/admin/user/store",
     *      operationId="store",
     *      tags={"admin,user,store"},
     *      summary="user",
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      description="",
     *      @OA\Parameter(
     *          name="name",
     *          description="Name",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          description="Email",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="role_id",
     *          description="Role Id",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="object"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password_confirmation",
     *          description="Password Confirmation",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->all();
            $user = $this->user->newInstance();
            $user->fill($inputs);
            $user->password = Hash::make($inputs['password']);
            if (!$user->save()) {
                DB::rollback();
                return error(GENERAL_ERROR_MESSAGE, ERROR_400);
            }
            $user->roles()->sync($inputs['role_id']);
            DB::commit();
            return successWithData(GENERAL_SUCCESS_MESSAGE, $user->fresh());
        } catch (QueryException $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        } catch (Exception $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/admin/user/update",
     *      operationId="update",
     *      tags={"admin,user,update"},
     *      summary="user",
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      description="",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          description="Name",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          description="Email",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="role_id",
     *          description="Role Id",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="object"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password_confirmation",
     *          description="Password Confirmation",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */

    public function update(UpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->all();
            $user = $this->user->newQuery()->whereId($inputs['id'])->first();
            $user->fill($inputs);
//            $user->password = Hash::make($inputs['password']);
            if (!$user->save()) {
                DB::rollback();
                return error(GENERAL_ERROR_MESSAGE, ERROR_400);
            }
            $user->roles()->sync($inputs['role_id']);
            DB::commit();
            return successWithData(GENERAL_UPDATED_MESSAGE, $user->fresh());
        } catch (QueryException $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        } catch (Exception $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/admin/user/delete",
     *      operationId="delete",
     *      tags={"admin,user,delete"},
     *      summary="user",
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      description="",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function delete(DeleteRequest $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->all();
            $user = $this->user->newQuery()->whereId($inputs['id'])->first();
            $user->roles()->detach();
            if (!$user->delete()) {
                DB::rollback();
                return error(GENERAL_ERROR_MESSAGE, ERROR_400);
            }
            DB::commit();
            return success(GENERAL_DELETED_MESSAGE);
        } catch (QueryException $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        } catch (Exception $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        }
    }

    /**
     * @OA\GET(
     *      path="/api/admin/user/role/listing",
     *      operationId="roleListing",
     *      tags={"admin,user,role,listing"},
     *      summary="user",
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      description="",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function roleListing(Request $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->all();
            $roles = $this->role->newQuery()->get();
            DB::commit();
            return successWithData(GENERAL_FETCHED_MESSAGE, $roles);
        } catch (QueryException $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        } catch (Exception $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        }
    }

    public function UpdateIsActive(UpdateIsActiveRequest $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->all();
            $user = $this->user->newQuery()->where('id', $inputs['id'])->first();
            if($user->is_active == true || $user->is_active == 1)
            {
                $user->is_active = 0;
            }else{
                $user->is_active = 1;
            }
            if (!$user->save()) {
                DB::rollback();
                return error(GENERAL_ERROR_MESSAGE, ERROR_400);
            }
            DB::commit();
            return success(GENERAL_UPDATED_MESSAGE);
        } catch (QueryException $e) {
            DB::rollBack();
            return error(GENERAL_ERROR_MESSAGE, ERROR_500);
        } catch (Exception $e) {
            DB::rollBack();
            return error(GENERAL_ERROR_MESSAGE, ERROR_500);
        }
    }

    public function UpdateIsShow(UpdateIsShowRequest $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->all();
            $user = $this->user->newQuery()->where('id', $inputs['id'])->first();
            if($user->is_show == true || $user->is_show == 1)
            {
                $user->is_show = 0;
            }else{
                $user->is_show = 1;
            }
            if (!$user->save()) {
                DB::rollback();
                return error(GENERAL_ERROR_MESSAGE, ERROR_400);
            }
            DB::commit();
            return success(GENERAL_UPDATED_MESSAGE);
        } catch (QueryException $e) {
            DB::rollBack();
            return error(GENERAL_ERROR_MESSAGE, ERROR_500);
        } catch (Exception $e) {
            DB::rollBack();
            return error(GENERAL_ERROR_MESSAGE, ERROR_500);
        }
    }
}
