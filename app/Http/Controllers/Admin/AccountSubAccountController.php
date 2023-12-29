<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountSubAccount\DeleteRequest;
use App\Http\Requests\AccountSubAccount\DetailRequest;
use App\Http\Requests\AccountSubAccount\ListingRequest;
use App\Http\Requests\AccountSubAccount\StoreRequest;
use App\Http\Requests\AccountSubAccount\UpdateIsActiveRequest;
use App\Http\Requests\AccountSubAccount\UpdateIsShowRequest;
use App\Http\Requests\AccountSubAccount\UpdateRequest;
use App\Models\Account;
use App\Models\AccountSubAccount;
use App\Models\SubAccount;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class AccountSubAccountController extends Controller
{
    private $pagination, $model, $accountModel;

    public function __construct()
    {
        $this->model = new AccountSubAccount();
        $this->accountModel = new Account();
        $this->pagination = request('page_size') ? request('page_size') : PAGINATE;
    }
    /**
     * @OA\GET(
     *      path="/api/admin/account_sub_account/listing",
     *      operationId="account_sub_account-listing",
     *      tags={"admin,account_sub_account,listing"},
     *      summary="account_sub_account",
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
        $query = $this->model->newQuery()->with(['account','subAccount']);
        if (!empty($inputs['search'])) {
            $query->where(function ($q) use ($inputs) {
                searchTable($q, $inputs['search'], ['name']);
            });
        }
        $accountSubAccounts = $query->paginate($this->pagination);
        return view('accountSubAccount.index', compact('accountSubAccounts'));
//        return successWithData(GENERAL_FETCHED_MESSAGE, $data);
    }
    public function create()
    {
        $accounts = Account::all();
        $subAccounts = SubAccount::all();
        return view('accountSubAccount.create',compact('accounts','subAccounts'));
    }

    /**
     * @OA\GET(
     *      path="/api/admin/account_sub_account/detail",
     *      operationId="account_sub_account-detail",
     *      tags={"admin,account_sub_account,detail"},
     *      summary="account_sub_account",
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
            ->with(['account','subAccount'])
            ->first();
        return view('transactions.list', ['transactions' => $data]);
//        return successWithData(GENERAL_FETCHED_MESSAGE, $data);
    }

    /**
     * @OA\POST(
     *      path="/api/admin/account_sub_account/store",
     *      operationId="account_sub_account-store",
     *      tags={"admin,account_sub_account,store"},
     *      summary="account_sub_account",
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      description="",
     *      @OA\Parameter(
     *          name="account_id",
     *          description="Account Id",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="sub_account_id",
     *          description="Sub Account Id",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="object"
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
            $data['account_id'] = $inputs['account_id'];
            if($this->model->whereAccountId($inputs['account_id'])->count() > 0)
            {
                $this->model->whereAccountId($inputs['account_id'])->delete();
            }
            foreach($inputs['sub_account_id'] as $subAccountId) {
                $model = $this->model->newInstance();
                $data['sub_account_id'] = $subAccountId;
                $model->fill($data);
                if (!$model->save()) {
                    DB::rollback();
                    redirect()->back()->with('error', 'Data no save properly');
//                    return error(GENERAL_ERROR_MESSAGE, ERROR_400);
                }
            }
            DB::commit();
            return redirect()->route('account_sub_account.listing')
                ->with('success', __('Manage Account created successfully.'));
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('account_sub_account.listing')
                ->with('error', $e->getMessage());
//            return error($e->getMessage(), ERROR_500);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('account_sub_account.listing')
                ->with('error', $e->getMessage());
//            return error($e->getMessage(), ERROR_500);
        }
    }

    /**
     * @OA\POST(
     *      path="/api/admin/account_sub_account/update",
     *      operationId="account_sub_account-update",
     *      tags={"admin,account_sub_account,update"},
     *      summary="account_sub_account",
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
     *          name="account_id",
     *          description="Account Id",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="sub_account_id",
     *          description="Sub Account Id",
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
//                return error(GENERAL_ERROR_MESSAGE, ERROR_400);
                redirect()->back()->with('error', 'Data no save properly');
            }
            DB::commit();
            return redirect()->route('account_sub_account.listing')
                ->with('success', __('Manage Account updated successfully.'));
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
     *      path="/api/admin/account_sub_account/delete",
     *      operationId="account_sub_account-delete",
     *      tags={"admin,account_sub_account,delete"},
     *      summary="account_sub_account",
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
     *      path="/api/admin/account_sub_account/UpdateIsActive",
     *      operationId="account_sub_account-UpdateIsActive",
     *      tags={"admin,account_sub_account,UpdateIsActive"},
     *      summary="account_sub_account",
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
     *      path="/api/admin/account_sub_account/updateIsShow",
     *      operationId="account_sub_account-updateIsShow",
     *      tags={"admin,account_sub_account,updateIsShow"},
     *      summary="account_sub_account",
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
            if ($model->is_show == true || $model->is_show == 1) {
                $model->is_show = 0;
            } else {
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
    public function getSubAccounts(Request $request)
    {
        $inputs = $request->all();

        // Fetch transactions based on the party ID and transaction type
        $subAccounts = SubAccount::all();
        $accountSubAccounts = AccountSubAccount::where('account_id', $inputs['account_id'])->get();
        // You can return the transactions as HTML, JSON, or in any format you prefer
        return view('accountSubAccount.render_file', ['subAccounts' => $subAccounts,'accountSubAccounts' => $accountSubAccounts]);
    }
}
