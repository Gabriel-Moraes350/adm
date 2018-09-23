<?php
/**
 * Created by PhpStorm.
 * User: Gabriel Moraes
 * Date: 26/08/2018
 * Time: 17:47
 */

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\User\UserAuthServices;
use App\Services\UserServices;
use Illuminate\Support\Facades\Input;

class UserController extends AdminBaseController
{
    protected $className = 'User';
    protected $objectName = 'Usuario';
    protected $routeName = 'adm.user';
    protected $fields =
        [
          'id' => ['type' => 'readonly', 'description' => 'Id'],
          'name' => ['type' => 'text', 'description' => 'Nome'],
          'login' => ['type' => 'email', 'description' => 'Email', 'required' => true],
          'password' => ['type' => 'password', 'description' => 'Senha', ],
            'roles' => ['type' => 'Role', 'description' => 'Níveis', 'checkbox' => true]
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
                ],
                'login' => [
                  'description' => 'Email'
                ],
            ],
            'showFilters' =>
            [
                'name' => 'Nome',
                'id' => 'Id'
            ]
        ];

    public function loginAdm()
    {
        if(\Request::isMethod('post'))
        {
            $input = Input::all();
            $userServices = new UserAuthServices();
            if($userServices->auth(UserAuthServices::USER_AUTH_BY_DEFAULT, ['login' => $input['email'], 'password' => $input['password']]))
            {
                return redirect()->route('adm.default');
            }
            return redirect()->back()->withErrors( 'Senha ou usuário inválidos');

        }

        return parent::renderView('user.login');
    }


    public function logout()
    {
        if($this->logoutUser())
        {
            return redirect()->route('adm.login');
        }

        return redirect()->back();
    }

    public function getLoggedUser()
    {

    }


    protected function store()
    {
        return $this->storeOrUpdateUser();
    }

    protected function update($id)
    {
        return $this->storeOrUpdateUser($id);
    }

    private function storeOrUpdateUser($id = null)
    {
        $input = Input::all();

        if(!empty($input))
        {
            $user = new User();
            $roles = !empty($input['roles']) ? $input['roles'] : null;

            foreach($user->getFillable() as $field)
            {
                if(!empty($input[$field]))
                {
                    $user->{$field} = $input[$field];
                }
            }

            if(!empty($id))
            {
                $user->id = $id;
            }

            $userServices = new UserServices();
            if($userServices->addOrUpdateUserRoles($user, $roles))
            {
                return parent::redirectWithSuccess();
            }
        }
        return parent::redirectWithError();
    }
}