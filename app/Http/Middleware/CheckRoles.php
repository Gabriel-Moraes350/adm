<?php

namespace App\Http\Middleware;

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
    public function handle($request, Closure $next, $params = Role::ROLE_ADMIN)
    {
//        dd($request);
        if(\Auth::check())
        {
            $userAuthServices = new UserAuthServices();
//            dd($request->user()->getRolesArray());
            if($userAuthServices->checkRoles($request->user()->getRolesArray(), $params))
            {
                return $next($request);
            }

        }elseif(\Route::currentRouteName() == 'adm.login')
        {
            return $next($request);
        }

        return \Redirect::route('adm.login');


    }
}
