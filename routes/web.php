<?php
//
//use App\Http\Controllers\ProfileController;
//use Illuminate\Support\Facades\Route;
//
///*
//|--------------------------------------------------------------------------
//| Web Routes
//|--------------------------------------------------------------------------
//|
//| Here is where you can register web routes for your application. These
//| routes are loaded by the RouteServiceProvider and all of them will
//| be assigned to the "web" middleware group. Make something great!
//|
//*/
//
//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});
//
//require __DIR__.'/auth.php';


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AccountSubAccountController;
use App\Http\Controllers\Admin\PartyAccountTransactionController;
use App\Http\Controllers\Admin\PartyController;
use App\Http\Controllers\Admin\PartyTransactionController;

//use App\Http\Controllers\Auth\AuthController;
//use App\Http\Controllers\Auth\ForgetController;
//use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\SubAccountController;
use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Authentication Routes

Route::get('/', function () {
    return view('welcome');
});

//Route::prefix('auth')->group(function () {
//    Route::controller(AuthController::class)->group(function () {
//        Route::post('login', 'login');
//        Route::post('logout', 'logout');
//    });
//    Route::controller(RegisterController::class)->group(function () {
//        Route::post('register', 'register');
//        Route::post('verifyEmailVerificationCode', 'verifyEmailVerificationCode');
//        Route::post('verificationCodeResend', 'verificationCodeResend');
//    });
//    Route::controller(ForgetController::class)->group(function () {
//        Route::post('forgetPasswordMail', 'forgetPasswordMail');
//        Route::post('verifyResetCode', 'verifyResetCode');
//        Route::post('resetPassword', 'resetPassword');
//    });
//});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
//Route::middleware('checkPermission')->group(function () {
//Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
//Route::prefix('admin')->group(function () {
Route::middleware('auth')->group(function () {
Route::controller(DashboardController::class)->group(function () {
    Route::get('dashboard', 'dashboard')->name('dashboard');
});
Route::prefix('profile')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('getUser', 'getUser');
        Route::post('uploadPhoto', 'uploadPhoto');
        Route::post('storeGeneralData', 'storeGeneralData');
        Route::post('updatePassword', 'updatePassword');
    });
});
Route::prefix('user')->name('user.')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('listing', 'listing')->name('listing');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('detail', 'detail');
        Route::post('store', 'store')->name('store');
        Route::post('update', 'update')->name('update');
        Route::post('delete', 'delete');
        Route::post('updateIsActive', 'updateIsActive');
        Route::post('updateIsShow', 'updateIsShow');
    });
});
Route::prefix('transaction')->name('transaction.')->group(function () {
    Route::controller(TransactionController::class)->group(function () {
        Route::get('listing', 'listing')->name('listing');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('detail', 'detail');
        Route::post('store', 'store')->name('store');
        Route::post('update', 'update')->name('update');
        Route::post('delete', 'delete');
        Route::post('updateIsActive', 'updateIsActive');
        Route::post('updateIsShow', 'updateIsShow');
    });
});
Route::prefix('party')->name('party.')->group(function () {
    Route::controller(PartyController::class)->group(function () {
        Route::get('listing', 'listing')->name('listing');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('detail', 'detail');
        Route::post('store', 'store')->name('store');
        Route::post('update', 'update')->name('update');
        Route::post('delete', 'delete');
        Route::post('updateIsActive', 'updateIsActive');
        Route::post('updateIsShow', 'updateIsShow');
    });
});
Route::prefix('account')->name('account.')->group(function () {
    Route::controller(AccountController::class)->group(function () {
        Route::get('listing', 'listing')->name('listing');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('detail', 'detail');
        Route::post('store', 'store')->name('store');
        Route::post('update', 'update')->name('update');
        Route::post('delete', 'delete');
        Route::post('updateIsActive', 'updateIsActive');
        Route::post('updateIsShow', 'updateIsShow');
    });
});
Route::prefix('party_transaction')->name('party_transaction.')->group(function () {
    Route::controller(PartyTransactionController::class)->group(function () {
        Route::get('listing', 'listing')->name('listing');
        Route::post('getTransactions', 'getTransactions')->name('getTransactions');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('detail', 'detail');
        Route::post('store', 'store')->name('store');
        Route::post('update', 'update')->name('update');
        Route::post('delete', 'delete');
        Route::post('updateIsActive', 'updateIsActive');
        Route::post('updateIsShow', 'updateIsShow');
    });
});
Route::prefix('party_account_transaction')->name('party_account_transaction.')->group(function () {
    Route::controller(PartyAccountTransactionController::class)->group(function () {
        Route::get('listing', 'listing')->name('listing');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('detail', 'detail');
        Route::post('store', 'store')->name('store');
        Route::post('update', 'update')->name('update');
        Route::post('delete', 'delete');
        Route::post('updateIsActive', 'updateIsActive');
        Route::post('updateIsShow', 'updateIsShow');
        Route::post('getTransactions', 'getTransactions')->name('getTransactions');
        Route::post('getSubAccounts', 'getSubAccounts')->name('getSubAccounts');
    });
});
Route::prefix('sub_account')->name('sub_account.')->group(function () {
    Route::controller(SubAccountController::class)->group(function () {
        Route::get('listing', 'listing')->name('listing');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('detail', 'detail');
        Route::post('store', 'store')->name('store');
        Route::post('update', 'update')->name('update');
        Route::post('delete', 'delete');
        Route::post('updateIsActive', 'updateIsActive');
        Route::post('updateIsShow', 'updateIsShow');
    });
});
Route::prefix('account_sub_account')->name('account_sub_account.')->group(function () {
    Route::controller(AccountSubAccountController::class)->group(function () {
        Route::get('listing', 'listing')->name('listing');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('detail', 'detail')->name('detail');
        Route::post('store', 'store')->name('store');
        Route::post('update', 'update')->name('update');
        Route::post('delete', 'delete');
        Route::post('updateIsActive', 'updateIsActive');
        Route::post('updateIsShow', 'updateIsShow');
        Route::post('getSubAccounts', 'getSubAccounts')->name('getSubAccounts');
    });
});
Route::prefix('role')->name('role.')->group(function () {
    Route::controller(RoleController::class)->group(function () {
        Route::get('listing', 'listing')->name('listing');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('detail', 'detail');
        Route::post('store', 'store')->name('store');
        Route::post('update', 'update')->name('update');
        Route::post('delete', 'delete');
        Route::post('updateIsActive', 'updateIsActive');
        Route::post('updateIsShow', 'updateIsShow');
    });
});
Route::prefix('permission')->name('permission.')->group(function () {
    Route::controller(PermissionController::class)->group(function () {
        Route::get('listing', 'listing')->name('listing');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('detail', 'detail');
        Route::post('store', 'store')->name('store');
        Route::post('update', 'update')->name('update');
        Route::post('delete', 'delete');
        Route::post('updateIsActive', 'updateIsActive');
        Route::post('updateIsShow', 'updateIsShow');
    });
//    });
});
Route::prefix('role_permission')->name('role_permission.')->group(function () {
    Route::controller(RolePermissionController::class)->group(function () {
        Route::get('listing', 'listing')->name('listing');
        Route::get('create', 'create')->name('create');
        Route::post('getPermissions', 'getPermissions')->name('getPermissions');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('detail', 'detail');
        Route::post('store', 'store')->name('store');
        Route::post('update', 'update')->name('update');
        Route::post('delete', 'delete');
        Route::post('updateIsActive', 'updateIsActive');
        Route::post('updateIsShow', 'updateIsShow');
    });
    });
});
require __DIR__.'/auth.php';
//Route::get('{any}', function () {
//    return view('welcome');
//})->where('any','.*');


