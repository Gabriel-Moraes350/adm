<?php
/**
 * Created by PhpStorm.
 * User: Gabriel Moraes
 * Date: 26/08/2018
 * Time: 17:47
 */

namespace App\Http\Controllers\Admin;


class PermissionController extends AdminBaseController
{
    protected $className = 'Spatie\Permission\Models\Permission';
    protected $objectName = 'Permissões';
    protected $routeName = 'adm.permission';
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