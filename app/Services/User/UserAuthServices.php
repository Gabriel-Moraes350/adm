<?php
/**
 * Created by PhpStorm.
 * User: Gabriel Moraes
 * Date: 06/09/2018
 * Time: 21:16
 */

namespace App\Services\User;

use App\Models\User;
use App\Services\RoleServices;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserAuthServices
{

    const USER_AUTH_BY_DEFAULT = 'default';
    const USER_AUTH_BY_ID = 'id';


    public function auth($type,$data = null)
    {
        switch($type)
        {
            case self::USER_AUTH_BY_ID:
                return $this->authById($data);
                break;

            case self::USER_AUTH_BY_DEFAULT:
            default:
                return $this->authByDefault($data);
                break;
        }

    }


    private function authByDefault($data)
    {
        if(!empty($data['login']) && !empty($data['password']))
        {
            if($user = \Auth::attempt($data))
            {
                return $user;
            }
        }

        return false;
    }



    private function authById($data)
    {
        if(!empty($data['id']))
        {
            if($user = \Auth::loginUsingId($data['id']))
            {
                return $user;
            }
        }

        return false;
    }


    public function checkRoles(User $user) : bool
    {
        if($user->hasAnyRole(Role::all()))
        {
            return true;
        }

        return false;
    }


    public function hasPermissions(User $user, string $className) : bool
    {
        $className = $this->convertClassName($className);
        $action = \Route::current()->getActionMethod();
        if($user->hasRole(RoleServices::ROLE_SUPER_ADMIN))
        {
            return true;
        }

        $action = $this->mapAction($action);


        try{

            if(empty($className))
                return true;
            foreach($user->roles as $role)
            {
                if($role->hasPermissionTo($className .'-'.$action))
                    return true;
            }
        }catch(\Exception $e){}


        return false;
    }


    private function convertClassName($className)
    {
        if(\strpos($className, '\\') !== false)
        {
            $className = \explode('\\', $className);
            $explodeName = $className[\count($className) -1];
            return \strtolower($explodeName);
        }

        return \strtolower($className);
    }

    private function mapAction($action)
    {
        switch($action)
        {
            case 'store':
                return 'create';
                break;
            case 'update':
                return 'edit';
                break;
            default:
                return $action;
        }
    }
}