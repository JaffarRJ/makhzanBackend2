<?php


namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\LogoutRequest;
use App\Jobs\SendMailJob;
use App\Models\NotificationDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use Exception;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    private $user, $notificationDevice;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      operationId="login",
     *      tags={"auth,login"},
     *      summary="authentication",
     *      description="",
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
     *          name="password",
     *          description="Password",
     *          required=true,
     *         in="query",
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
    public function login(LoginRequest $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->all();
            if ($user = $this->user->newQuery()->where('email', $inputs['email'])->first()) {
                if (Hash::check($inputs['password'], $user->password)) {
                    Auth::login($user);
                    $user = Auth::user();
                    $getRole = Role::where('id', $user['role_id'])->first();
                    if (!empty($getRole) && !empty($getRole['permissions'])) {
                        $permission = $getRole['permissions'];

//                         return view('welcome', ['permission' => $permission]);
//                        return View::make('welcome', compact('permission'));
                        return successWithData(GENERAL_LOGIN_MESSAGE, $permission);
//                        $this->checkForPermission($getRole, $request);
                    } else {
                        return response()->json(['success' => false, 'message' => 'Access Denied'], ERROR_500);
                        return view('/login');
                    }
                    if (!Auth::check() && $request->path() != 'login') {
                        return response()->json(['success' => false, 'message' => 'Access Denied'], ERROR_500);
                        return view('/login');
                    }
                    if (!Auth::check() && $request->path() == 'login') {
                        return response()->json(['success' => false, 'message' => 'Access Denied'], ERROR_500);
                        return view('/login');
                        return view('/login');

                    }
                }
            }
            DB::rollback();
            return error(__('auth.invalidCredentials'), SUCCESS_200);
        } catch (QueryException $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        } catch (Exception $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        }
    }


    public function logout(LogoutRequest $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->all();
            $notificationDevice = $this->notificationDevice->newQuery()->where('uuid', $inputs['uuid'])->first();
            if (!$notificationDevice) {
                DB::rollBack();
                return error(GENERAL_ERROR_MESSAGE, ERROR_400);
            }
            if (!$notificationDevice->delete()) {
                DB::rollBack();
                return error(GENERAL_ERROR_MESSAGE, ERROR_400);
            }
            $token = $request->header('Authorization');
            if ($token) {
                JWTAuth::invalidate($token);
            }
            DB::commit();
            return success('Logged Out Succesfully');

        } catch (QueryException $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        } catch (Exception $e) {
            DB::rollBack();
            return error($e->getMessage(), ERROR_500);
        }

    }

//    public function checkForPermission($role, $request)
//    {
//        $permission = json_decode($role['permissions']);
//        $hasPermission = false;
//        if (!$permission) {
//            return view('welcome');
//        }
//        foreach ($permission as $p) {
//            if ($p->name == $request->path()) {
//                if ($p->read) {
//                    $hasPermission = true;
//                }
//            }
//        }
//        echo '<pre>';
//        print_r($hasPermission);
//        exit;
//        if ($hasPermission) {
//            return view('welcome');
//        }
//
//        return view('welcome');
//        return view('notfound');
//    }


}
