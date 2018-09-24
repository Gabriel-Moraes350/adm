<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Role;
use App\Services\User\UserAuthServices;
use Closure;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $params)
    {

        if(\Auth::check())
        {
            if(empty($params) || \count($params) == 0)
            {
                return $next($request);
            }

            if($params == AdminBaseController::ADMIN_MIDDLEWARE)
            {
                $userAuthServices = new UserAuthServices();
                if(($roles = \Route::current()->getController()->getRoleOwner()) && $roles !== false)
                {
                    if(\is_array($roles) && $request->user()->hasAnyRole($roles))
                        return $next($request);
                    elseif($request->user()->hasRole($roles))
                        return $next($request);
                }
                elseif($userAuthServices->hasPermissions($request->user(), \Route::current()->getController()->getClassName()))
                {
                    return $next($request);
                }

                return redirect()->back()->withErrors('Sem permissão');

            }
        }
        return \Redirect::route('adm.login');


    }
}
