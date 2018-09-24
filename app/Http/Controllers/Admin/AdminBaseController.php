<?php
/**
 * Created by PhpStorm.
 * User: Gabriel Moraes
 * Date: 27/08/2018
 * Time: 23:34
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\DefaultController;
use App\Http\Controllers\DefaultResponseController;
use App\Models\Role;
use Illuminate\Support\Facades\Input;

class AdminBaseController extends DefaultController
{
    protected $view = [];
    protected $objectName = '';
    protected $className = '';
    protected $fields = [];
    protected $routeName = 'adm';
    protected $data = [];
    protected $customIndex = [];
    protected $response;

    private $call_class;

    const NAMESPACE_MODELS = 'App\Models\\';
    const ADMIN_MIDDLEWARE = 'admin';
    public function __construct()
    {
        $this->middleware('checkRoles:'.self::ADMIN_MIDDLEWARE)->except(['loginAdm', 'logout']);
        $this->data['objectName'] = $this->objectName;
        $this->data['routeName'] = $this->routeName;
        $this->data['fields'] = $this->fields;
        $this->call_class = \strpos($this->className, '\\') !== false ? $this->className : self::NAMESPACE_MODELS . $this->className;
        $this->response = new DefaultResponseController();
    }


    public function getClassName()
    {
        return $this->className;
    }


    public function getRoleOwner()
    {
        return false;
    }

    public function default()
    {
        return $this->renderView('default');
    }

    protected function index()
    {
        $this->data['index'] = $this->customIndex;
        $input = Input::all();

        $objects  = \call_user_func_array( $this->call_class . '::orderBy',['id', 'desc']);
        if(!empty($input['filter']) && !empty($input['find']))
        {
            if(\in_array($input['filter'],['name', 'email']))
            {
                $objects->where($input['filter'],'like','%'.$input['find'] . '%');
            }else{
                $objects->where($input['filter'],$input['find']);

            }
        }

        $objects = $objects->paginate(15);
        $this->data['objects'] = $objects;
        return parent::renderView('index',$this->data);
    }

    protected function edit($id)
    {
        if(!isset($this->data['object']))
        {
            $object = \call_user_func_array([$this->call_class, 'find'], [$id]);
            $this->makeTypeFields($object);

        }
        $this->data['object'] = $object;
        return parent::renderView('edit', $this->data);
    }


    /**
     * Method to update
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function update($id)
    {
        $input = Input::all();
        $dataToSave = [];
        try{
            $object = \call_user_func_array([$this->call_class, 'find'], [$id]);

            foreach($this->fields as $field => $val)
            {
                if(!empty($input[$field]) &&  $input[$field] != $object->{$field})
                {
                    $dataToSave[$field] = $input[$field];
                }
            }
            if(!$object->update($dataToSave))
            {
                return redirect()->back()->withErrors('Ocorreu um erro ao salvar')->withInput();
            }
        }catch(\Exception $e){}

        return redirect()->route($this->routeName . '.index')->withSuccess('Salvo com sucesso');
    }


    /**
     * Method to destroy item
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    protected function destroy($id)
    {
        if(!empty($id))
        {
            try{
                if(\call_user_func_array(self::NAMESPACE_MODELS.$this->className.'::find',[$id])->delete())
                {
                    return $this->response->responseAjaxSuccess();
                }
            }catch(\Exception $e){}
        }

        return $this->response->responseAjaxError();
    }


    /**
     * Method to only show the item not EDIT
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function show($id)
    {
        return $this->edit($id);
    }


    /**
     * Method to return create view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function create()
    {
        $this->makeTypeFields();
        return parent::renderView('create');
    }


    /**
     * Method to store on db after create
     */
    protected function store()
    {
        $input = Input::all();
        if(!empty($input))
        {
            try{
                if($object = \call_user_func_array($this->call_class . '::create',[$input]))
                {
                    return $this->redirectWithSuccess();
                }
            }catch(\Exception $e){}

        }
        return $this->response->redirectWithError();
    }

    /**
     * Method to make fields in edit and create
     *
     * @param $val
     * @param $object
     */
    protected function makeTypeFields($object = null): void
    {
        foreach ($this->data['fields'] as $field => &$val) {
            if (!\in_array($val['type'], ['readonly', 'hidden', 'text', 'number', 'checkbox', 'email', 'password', 'select'])) {
                $call_class = \strpos($val['type'], '\\') !== false ? $val['type'] : self::NAMESPACE_MODELS . $val['type'];
                $objArray = \call_user_func_array([$call_class, 'get'], []);
                $objData = [];
                if(empty($val['checkbox']))
                {
                    $objData[0] = '---';
                    $val['type'] = 'select';
                }else
                {
                    $val['type'] = 'checkbox';
                }

                foreach ($objArray as $value) {
                    $objData[$value->id] = $value->name;
                }

                $val['data'] = $objData;

            }
            if(!empty($object))
            {
                $val['default'] = $object->{$field};
            }
        }
    }

    /**
     * Method to redirect with success
     *
     * @param string $message
     * @return mixed
     */
    protected function redirectWithSuccess($message = 'Sucesso')
    {
        return redirect()->route($this->routeName .'.index')->withSuccess($message);
    }


    /**
     * Method to redirect with error
     *
     * @param string $error
     * @return DefaultResponseController
     */
    protected function redirectWithError($error = 'Erro')
    {
        return $this->response->redirectWithError($error);
    }
}