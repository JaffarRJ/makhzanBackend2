<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartyAccountTransaction\DeleteRequest;
use App\Http\Requests\Api\PartyAccountTransaction\DetailRequest;
use App\Http\Requests\PartyAccountTransaction\ListingRequest;
use App\Http\Requests\PartyAccountTransaction\StoreRequest;
use App\Http\Requests\PartyAccountTransaction\UpdateIsActiveRequest;
use App\Http\Requests\PartyAccountTransaction\UpdateIsShowRequest;
use App\Http\Requests\PartyAccountTransaction\UpdateRequest;
use App\Models\Party;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\subAccount;
use App\Models\PartyAccountTransaction;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PartyAccountTransactionController extends Controller
{
    private $pagination, $model;

    public function __construct()
    {
        $this->model = new PartyAccountTransaction();
        $this->pagination = request('page_size') ? request('page_size') : PAGINATE;
    }
    /**
     * @OA\GET(
     *      path="/api/admin/party_account_transaction/listing",
     *      operationId="party_account_transaction-listing",
     *      tags={"admin,party_account_transaction,listing"},
     *      summary="party_account_transaction",
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
        $query = $this->model->newQuery()->with(['party', 'transaction','account','sub_account']);
        if (!empty($inputs['search'])) {
            $query->where(function ($q) use ($inputs) {
                searchTable($q, $inputs['search'], ['name']);
            });
        }
        $partyAccountTransaction = $query->paginate($this->pagination);
        return view('partyAccountTransaction.index', compact('partyAccountTransaction'));
//        return successWithData(GENERAL_FETCHED_MESSAGE, $data);
    }
    public function create()
    {
        $parties = Party::all();
        $transactions = Transaction::all();
        $accounts = Account::all();
        $subAccounts = subAccount::all();
        return view('partyAccountTransaction.create',compact('parties','transactions','accounts','subAccounts'));
    }
    public function edit($id)
    {
        $parties = Party::all();
//        $transactions = Transaction::all();
        $accounts = Account::all();
//        $subAccounts = subAccount::all();
        $partyAccountTransaction = PartyAccountTransaction::findOrFail($id);
        $getaccount = Account::findOrFail($partyAccountTransaction->account_id);
        $subAccounts = $getaccount->sub_accounts;
        $party = Party::findOrFail($partyAccountTransaction->party_id);
        $transactions = $party->transactions;
        return view('partyAccountTransaction.edit', compact('parties','transactions','accounts','subAccounts','partyAccountTransaction'));
    }

    /**
     * @OA\GET(
     *      path="/api/admin/party_account_transaction/detail",
     *      operationId="party_account_transaction-detail",
     *      tags={"admin,party_account_transaction,detail"},
     *      summary="party_account_transaction",
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
            ->with(['account', 'partyTransaction' => function($q){
                $q->with(['transaction', 'party']);
            }])
            ->first();
        return successWithData(GENERAL_FETCHED_MESSAGE, $data);
    }

    /**
     * @OA\POST(
     *      path="/api/admin/party_account_transaction/store",
     *      operationId="party_account_transaction-store",
     *      tags={"admin,party_account_transaction,store"},
     *      summary="party_account_transaction",
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      description="",
     *      @OA\Parameter(
     *          name="party_transaction_id",
     *          description="Party Transaction Id",
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
     *          name="dr",
     *          description="Dr",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="cr",
     *          description="Cr",
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
                redirect()->back()->with('error', 'Data no save properly');
            }
            DB::commit();
            return redirect()->route('party_account_transaction.listing')
                ->with('success', __('Account created successfully.'));
//            return successWithData(GENERAL_SUCCESS_MESSAGE, $model->fresh());
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('party_account_transaction.listing')
                ->with('error', $e->getMessage());
//            return error($e->getMessage(), ERROR_500);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('party_account_transaction.listing')
                ->with('error', $e->getMessage());
//            return error($e->getMessage(), ERROR_500);
        }
    }

    /**
     * @OA\POST(
     *      path="/api/admin/party_account_transaction/update",
     *      operationId="party_account_transaction-update",
     *      tags={"admin,party_account_transaction,update"},
     *      summary="party_account_transaction",
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
     *          name="party_transaction_id",
     *          description="Party Transaction Id",
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
     *          name="dr",
     *          description="Dr",
     *          required=true,
     *           in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="cr",
     *          description="Cr",
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
            return redirect()->route('party_account_transaction.listing')
                ->with('success', __('Account updated successfully.'));
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
     *      path="/api/admin/party_account_transaction/delete",
     *      operationId="party_account_transaction-delete",
     *      tags={"admin,party_account_transaction,delete"},
     *      summary="party_account_transaction",
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
     *      path="/api/admin/party_account_transaction/UpdateIsActive",
     *      operationId="party_account_transaction-UpdateIsActive",
     *      tags={"admin,party_account_transaction,UpdateIsActive"},
     *      summary="party_account_transaction",
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
     *      path="/api/admin/party_account_transaction/updateIsShow",
     *      operationId="party_account_transaction-updateIsShow",
     *      tags={"admin,party_account_transaction,updateIsShow"},
     *      summary="party_account_transaction",
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
    public function getTransactions(ListingRequest $request)
    {
        $inputs = $request->all();
        // Find the party by ID
        $party = Party::findOrFail($inputs['id']);

        // Get transactions for the party
        $transactions = $party->transactions;
        return view('partyAccountTransaction.renderTransaction', compact('transactions'));
    }
    public function getSubAccounts(ListingRequest $request)
    {
        $inputs = $request->all();
        // Find the party by ID
        $account = Account::findOrFail($inputs['id']);

        // Get transactions for the party
        $subAccounts = $account->sub_accounts;
        return view('partyAccountTransaction.rendersubAccount', compact('subAccounts'));
    }
}
