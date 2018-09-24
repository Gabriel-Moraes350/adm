<?php
/**
 * Created by PhpStorm.
 * User: Gabriel Moraes
 * Date: 26/08/2018
 * Time: 17:47
 */

namespace App\Http\Controllers\Admin;

use App\Services\RoleServices;
use App\Services\User\UserAuthServices;
use Illuminate\Support\Facades\Input;

class RoleController extends AdminBaseController
{
    protected $className = 'Spatie\Permission\Models\Role';
    protected $objectName = 'Acesso';
    protected $routeName = 'adm.role';
    protected $fields =
        [
            'id' => ['type' => 'readonly', 'description' => 'Id'],
            'name' => ['type' => 'text', 'description' => 'Nome'],
            'permissions' => ['type' => 'Spatie\Permission\Models\Permission', 'description' => 'Permissões', 'checkbox' => true]
        ];

    protected $customIndex =
        [
            'actions' => [
                'show' => true,
                'destroy' => true,
                'edit' => true,
                'create' => true
            ],
            'showFields' => [
                'name' => [
                    'description' => 'Nome',
                ]
            ],
            'showFilters' =>
                [
                    'name' => 'Nome',
                    'id' => 'Id'
                ]
        ];


    protected function store()
    {
        return $this->storeOrUpdateRole();
    }

    protected function update($id)
    {
        return $this->storeOrUpdateRole($id);
    }

    private function storeOrUpdateRole($id = null)
    {
        $input = Input::all();
        $roleServices = new RoleServices();
        if($roleServices->makeRoleById($input, $id))
        {
            return parent::redirectWithSuccess();
        }

        return parent::redirectWithError();
    }


}