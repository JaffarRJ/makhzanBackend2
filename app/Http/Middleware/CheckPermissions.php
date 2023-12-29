<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\RolePermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->path() == '/login'){
            return $next($request);
        }
        if(!Auth::check()){
            return response()->json(['success' => false, 'message' => 'Access Denied'], ERROR_500);
        }
        $user = Auth::user();
        if($user->role->name == 0){
            return response()->json(['success' => false, 'message' => 'Access Denied'], ERROR_500);
        }
        return $next($request);
    }
}
