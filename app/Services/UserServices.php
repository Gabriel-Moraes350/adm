<?php
/**
 * Created by PhpStorm.
 * User: Gabriel Moraes
 * Date: 27/08/2018
 * Time: 23:39
 */

namespace App\Services;


use App\Models\User;

class UserServices
{

    /**
     * Method to add user with role
     *
     * @param User $userObject
     * @param array $roles
     * @return bool
     */
    public function addOrUpdateUserRoles(User $userObject, $roles = []) : bool
    {
        if(empty($userObject))
            return false;

        if(empty($userObject->id))
        {
            try{
                if($user = User::create($userObject->getAttributes()))
                {
                    $user->syncRoles($roles);
                    return true;
                }
            }catch(\Exception $e){}

        }else
        {
            $user = User::find($userObject->id);
            try
            {
                if(!empty($user) && $user->update($userObject->getAttributes()))
                {
                    $user->syncRoles($roles);
                    return true;
                }
            }catch(\Exception $e){}

        }

        return false;
    }
}