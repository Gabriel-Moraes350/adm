<?php
/**
 * Created by PhpStorm.
 * User: Gabriel Moraes
 * Date: 26/08/2018
 * Time: 17:47
 */

namespace App\Http\Controllers\Admin;

use App\Services\User\UserAuthServices;
use Illuminate\Support\Facades\Input;

class RoleController extends AdminBaseController
{
    protected $className = 'Role';
    protected $objectName = 'Acesso';
    protected $routeName = 'adm.role';
    protected $fields =
        [
            'id' => ['type' => 'readonly', 'description' => 'Id'],
            'name' => ['type' => 'text', 'description' => 'Nome'],
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


}