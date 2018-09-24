<?php
/**
 * Created by PhpStorm.
 * User: Gabriel Moraes
 * Date: 23/09/2018
 * Time: 22:28
 */

namespace App\Services;


use App\Models\Role;



class RoleServices
{
    const ROLE_SUPER_ADMIN = 'SuperAdmin';
    const ROLE_ADMIN = 'Admin';
    public function makeRoleById($input, $id = null)
    {
        if(empty($input))
            return false;

        try{
            $permissions = !empty($input['permissions']) ? $input['permissions'] : [];
            if(empty($id) && $role = \Spatie\Permission\Models\Role::create(['name' => $input['name']]))
            {
                $role->syncPermissions($permissions);
                return true;
            }

            $role = \Spatie\Permission\Models\Role::findById($id);
            if($role->update(['name' => $input['name']]))
            {
                $permissions = !empty($input['permissions']) ? $input['permissions'] : [];
                $role->syncPermissions($permissions);
                return true;
            }
        }catch(\Exception $e){}

        return false;
    }
}