<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Role\DeleteRequest;
use App\Http\Requests\Api\Role\DetailRequest;
use App\Http\Requests\Api\Role\ListingRequest;
use App\Http\Requests\Api\Role\StoreRequest;
use App\Http\Requests\Api\Role\AssignRequest;
use App\Http\Requests\Api\Role\UpdateIsActiveRequest;
use App\Http\Requests\Api\Role\UpdateIsShowRequest;
use App\Http\Requests\Api\Role\UpdateRequest;
use App\Models\Role;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    private $pagination, $model;

    public function __construct()
    {
        $this->model = new Role();
        $this->pagination = request('page_size') ? request('page_size') : PAGINATE;
    }
    /**
     * @OA\GET(
     *      path="/api/admin/role/listing",
     *      operationId="role-data-listing",
     *      tags={"admin,role,listing"},
     *      summary="role",
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
    public function listing(ListingRequest $request)
    {
        $inputs = $request->all();
        $query = $this->model->newQuery();
        if (!empty($inputs['search'])) {
            $query->where(function ($q) use ($inputs) {
                searchTable($q, $inputs['search'], ['name']);
            });
        }
        $data = $query->paginate($this->pagination);
        return successWithData(GENERAL_FETCHED_MESSAGE, $data);
    }

    /**
     * @OA\GET(
     *      path="/api/admin/role/detail",
     *      operationId="role-detail",
     *      tags={"admin,role,detail"},
     *      summary="role",
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
        $data = $this->model->newQuery()
            ->whereId($inputs['id'])->first();
        return successWithData(GENERAL_FETCHED_MESSAGE, $data);
    }

    /**
     * @OA\POST(
     *      path="/api/admin/role/store",
     *      operationId="role-store",
     *      tags={"admin,role,store"},
     *      summary="role",
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
            $model = $this->model->newInstance();
            $model->fill($inputs);
            if (!$model->save()) {
                DB::rollback();
                return error(GENERAL_ERROR_MESSAGE, ERROR_400);
            }
            DB::commit();
            return successWithData(GENERAL_SUCCESS_MESSAGE, $model->fresh());
        } catch (QueryException $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        } catch (Exception $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        }
    }

    /**
     * @OA\POST(
     *      path="/api/admin/role/update",
     *      operationId="role-update",
     *      tags={"admin,role,update"},
     *      summary="role",
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
            $model = $this->model->newQuery()->where('id', $inputs['id'])->first();
            $model->fill($inputs);
            if (!$model->save()) {
                DB::rollback();
                return error(GENERAL_ERROR_MESSAGE, ERROR_400);
            }
            DB::commit();
            return successWithData(GENERAL_SUCCESS_MESSAGE, $model->fresh());
        } catch (QueryException $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        } catch (Exception $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        }
    }

    /**
     * @OA\POST(
     *      path="/api/admin/role/delete",
     *      operationId="role-delete",
     *      tags={"admin,role,delete"},
     *      summary="role",
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
            $model = $this->model->newQuery()->where('id', $inputs['id'])->first();
            if (!$model->delete()) {
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

    public function assignRole(AssignRequest $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->all();
            $model = $this->model->newQuery()->where('id', $inputs['id'])->first();
            $model->fill($inputs);
            if (!$model->save()) {
                DB::rollback();
                return error(GENERAL_ERROR_MESSAGE, ERROR_400);
            }
            DB::commit();
            return successWithData(GENERAL_SUCCESS_MESSAGE, $model->fresh());
        } catch (QueryException $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        } catch (Exception $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        }
    }

    /**
     * @OA\POST(
     *      path="/api/admin/role/UpdateIsActive",
     *      operationId="role-UpdateIsActive",
     *      tags={"admin,role,UpdateIsActive"},
     *      summary="role",
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

    public function UpdateIsActive(UpdateIsActiveRequest $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->all();
            $model = $this->model->newQuery()->where('id', $inputs['id'])->first();
            if($model->is_active == true || $model->is_active == 1)
            {
                $model->is_active = 0;
            }else{
                $model->is_active = 1;
            }
            if (!$model->save()) {
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

    /**
     * @OA\POST(
     *      path="/api/admin/role/updateIsShow",
     *      operationId="role-updateIsShow",
     *      tags={"admin,role,updateIsShow"},
     *      summary="role",
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

    public function updateIsShow(UpdateIsShowRequest $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->all();
            $model = $this->model->newQuery()->where('id', $inputs['id'])->first();
            if($model->is_show == true || $model->is_show == 1)
            {
                $model->is_show = 0;
            }else{
                $model->is_show = 1;
            }
            if (!$model->save()) {
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
