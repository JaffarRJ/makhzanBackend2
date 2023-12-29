<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PartyTransaction\DeleteRequest;
use App\Http\Requests\Api\PartyTransaction\DetailRequest;
use App\Http\Requests\Api\PartyTransaction\ListingRequest;
use App\Http\Requests\Api\PartyTransaction\StoreRequest;
use App\Http\Requests\Api\PartyTransaction\UpdateIsActiveRequest;
use App\Http\Requests\Api\PartyTransaction\UpdateIsShowRequest;
use App\Http\Requests\Api\PartyTransaction\UpdateRequest;
use App\Models\PartyTransaction;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PartyTransactionController extends Controller
{
    private $pagination, $model;

    public function __construct()
    {
        $this->model = new PartyTransaction();
        $this->pagination = request('page_size') ? request('page_size') : PAGINATE;
    }
    /**
     * @OA\GET(
     *      path="/api/admin/party_transaction/listing",
     *      operationId="party_transaction-listing",
     *      tags={"admin,party_transaction,listing"},
     *      summary="party_transaction",
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
        $query = $this->model->newQuery()->with(['transaction', 'party']);
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
     *      path="/api/admin/party_transaction/detail",
     *      operationId="party_transaction-detail",
     *      tags={"admin,party_transaction,detail"},
     *      summary="party_transaction",
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
            ->with(['transaction', 'party'])
            ->first();
        return successWithData(GENERAL_FETCHED_MESSAGE, $data);
    }

    /**
     * @OA\POST(
     *      path="/api/admin/party_transaction/store",
     *      operationId="party_transaction-store",
     *      tags={"admin,party_transaction,store"},
     *      summary="party_transaction",
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      description="",
     *      @OA\Parameter(
     *          name="party_id",
     *          description="Party Id",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="transaction_id",
     *          description="Transaction Id",
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
            $data['party_id'] = $inputs['party_id'];
            if($this->model->wherePartyId($inputs['party_id'])->count() > 0)
            {
                $this->model->wherePartyId($inputs['party_id'])->delete();
            }
            foreach($inputs['transaction_id'] as $transactionId) {
                $model = $this->model->newInstance();
                $data['transaction_id'] = $transactionId;
                $model->fill($data);
                if (!$model->save()) {
                    DB::rollback();
                    return error(GENERAL_ERROR_MESSAGE, ERROR_400);
                }
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
     *      path="/api/admin/party_transaction/update",
     *      operationId="party_transaction-update",
     *      tags={"admin,party_transaction,update"},
     *      summary="party_transaction",
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
     *          name="party_id",
     *          description="Party Id",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="transaction_id",
     *          description="Transaction Id",
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
     *      path="/api/admin/party_transaction/delete",
     *      operationId="party_transaction-delete",
     *      tags={"admin,party_transaction,delete"},
     *      summary="party_transaction",
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
     *      path="/api/admin/party_transaction/UpdateIsActive",
     *      operationId="party_transaction-UpdateIsActive",
     *      tags={"admin,party_transaction,UpdateIsActive"},
     *      summary="party_transaction",
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
     *      path="/api/admin/party_transaction/updateIsShow",
     *      operationId="party_transaction-updateIsShow",
     *      tags={"admin,party_transaction,updateIsShow"},
     *      summary="party_transaction",
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
