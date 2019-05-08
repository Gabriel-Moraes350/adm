<?php
Theme::set('admin');
Route::group(['namespace' => 'Admin'],function(){
    Route::get('/', ['as' =>'adm.default' ,'uses' => 'AdminBaseController@default']);

    Route::match(['post','get'],'/login',['uses' => 'UserController@loginAdm'])->name('adm.login');

    Route::get('/logout','UserController@logout')->name('adm.logout');

    Route::resource('user','UserController',['as' => 'adm']);

    Route::resource('role', 'RoleController', ['as' => 'adm']);

    Route::resource('article', 'ArticlesController', ['as' => 'adm']);

});

