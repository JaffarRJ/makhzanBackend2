<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolePermission\DeleteRequest;
use App\Http\Requests\RolePermission\DetailRequest;
use App\Http\Requests\RolePermission\ListingRequest;
use App\Http\Requests\RolePermission\StoreRequest;
use App\Http\Requests\RolePermission\UpdateIsActiveRequest;
use App\Http\Requests\RolePermission\UpdateIsShowRequest;
use App\Http\Requests\RolePermission\UpdateRequest;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Permission;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    private $pagination, $model;

    public function __construct()
    {
        $this->model = new RolePermission();
        $this->pagination = request('page_size') ? request('page_size') : PAGINATE;
    }
    /**
     * @OA\GET(
     *      path="/api/admin/role_permission/listing",
     *      operationId="role_permission-listing",
     *      tags={"admin,role_permission,listing"},
     *      summary="role_permission",
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
        $query = $this->model->newQuery()->with(['permission', 'role']);
        if (!empty($inputs['search'])) {
            $query->where(function ($q) use ($inputs) {
                searchTable($q, $inputs['search'], ['name']);
            });
        }
        $rolePermissions = $query->paginate($this->pagination);
        return view('rolePermission.index', compact('rolePermissions'));
//        return successWithData(GENERAL_FETCHED_MESSAGE, $data);
    }
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('rolePermission.create',compact('roles','permissions'));
    }

    /**
     * @OA\GET(
     *      path="/api/admin/role_permission/detail",
     *      operationId="role_permission-detail",
     *      tags={"admin,role_permission,detail"},
     *      summary="role_permission",
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
            ->whereId($inputs['id'])
            ->with(['permission', 'role'])
            ->first();
        return successWithData(GENERAL_FETCHED_MESSAGE, $data);
    }

    /**
     * @OA\POST(
     *      path="/api/admin/role_permission/store",
     *      operationId="role_permission-store",
     *      tags={"admin,role_permission,store"},
     *      summary="role_permission",
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      description="",
     *      @OA\Parameter(
     *          name="role_id",
     *          description="role Id",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="permission_id",
     *          description="permission Id",
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
            $data = [];
            $data['role_id'] = $inputs['role_id'];
            if($this->model->whereRoleId($inputs['role_id'])->count() > 0)
            {
                $this->model->whereRoleId($inputs['role_id'])->delete();
            }
            foreach($inputs['permission_id'] as $permissionId) {
                $model = $this->model->newInstance();
                $data['permission_id'] = $permissionId;
                $model->fill($data);
                if (!$model->save()) {
                    DB::rollback();
                    redirect()->back()->with('error', 'Data no save properly');
//                    return error(GENERAL_ERROR_MESSAGE, ERROR_400);
                }
            }
            DB::commit();
            return redirect()->route('role_permission.listing')
                ->with('success', __('Manage Role created successfully.'));
//            return successWithData(GENERAL_SUCCESS_MESSAGE, $model->fresh());
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('role_permission.listing')
                ->with('error', $e->getMessage());
//            return error($e->getMessage(), ERROR_500);
        }
    }

    /**
     * @OA\POST(
     *      path="/api/admin/role_permission/update",
     *      operationId="role_permission-update",
     *      tags={"admin,role_permission,update"},
     *      summary="role_permission",
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
     *          name="role_id",
     *          description="role Id",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="permission_id",
     *          description="permission Id",
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
                redirect()->back()->with('error', 'Data no save properly');
//                return error(GENERAL_ERROR_MESSAGE, ERROR_400);
            }
            DB::commit();
            return redirect()->route('role_permission.listing')
                ->with('success', __('Manage Role updated successfully.'));
//            return successWithData(GENERAL_SUCCESS_MESSAGE, $model->fresh());
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
     *      path="/api/admin/role_permission/delete",
     *      operationId="role_permission-delete",
     *      tags={"admin,role_permission,delete"},
     *      summary="role_permission",
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

    /**
     * @OA\POST(
     *      path="/api/admin/role_permission/UpdateIsActive",
     *      operationId="role_permission-UpdateIsActive",
     *      tags={"admin,role_permission,UpdateIsActive"},
     *      summary="role_permission",
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
     *      path="/api/admin/role_permission/updateIsShow",
     *      operationId="role_permission-updateIsShow",
     *      tags={"admin,role_permission,updateIsShow"},
     *      summary="role_permission",
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
    public function getPermissions(Request $request)
    {
        $inputs = $request->all();

        // Fetch permissions based on the role ID and permission type
        $permissions = Permission::all();
        $rolePermission = RolePermission::where('role_id', $inputs['role_id'])->get();
        return view('rolePermission.render_file', ['permissions' => $permissions,'rolePermission' => $rolePermission]);
    }
}
