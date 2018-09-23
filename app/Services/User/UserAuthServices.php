<?php
/**
 * Created by PhpStorm.
 * User: Gabriel Moraes
 * Date: 06/09/2018
 * Time: 21:16
 */

namespace App\Services\User;

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
    }


    public function checkRoles($userRoles,$roles)
    {
        if(\is_array($roles))
        {
            foreach($roles as $role)
            {
                if(\in_array($role, $userRoles))
                {
                    return true;
                }
            }
        } else {
            if(\in_array($roles,$userRoles))
            {
                return true;
            }

        }

        return false;
    }

}