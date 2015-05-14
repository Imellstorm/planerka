<?php
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::controller('/auth', 'AuthController');

/*
|--------------------------------------------------------------------------
| For All
|--------------------------------------------------------------------------
*/
Route::post('admin/users/validate', 'UserController@postValidate');
Route::post('admin/users/store', 'UserController@postStore');
Route::put('admin/users/update/{id}', 'UserController@putUpdate');
Route::get('account/verifyemail/{data}','AccountController@getVerifyemail');
Route::controller('password', 'RemindersController');



/*
|--------------------------------------------------------------------------
| For admin
|--------------------------------------------------------------------------
*/

Route::group(array('before' => 'is_admin_filter'), function() {	
	Route::get('admin', 'UserController@getIndex');
	Route::get('admin/orders/{id}', 'OrderController@getUserOrders');
	Route::controller('admin/users', 'UserController');
	Route::controller('admin/articles', 'ArticleController');
	Route::controller('admin/roles', 'RoleController');
	Route::controller('admin/settings', 'SettingsController');
	Route::controller('admin/menus', 'MenuController');
});

/*
|--------------------------------------------------------------------------
| For registered users
|--------------------------------------------------------------------------
*/

Route::group(array('before' => 'auth'), function() {		
	Route::controller('account','AccountController');
	Route::controller('userinfo','UserinfoController');	
	Route::controller('specializations','SpecializationsController');
	Route::controller('settings','SettingsController');	
	Route::controller('album','AlbumsController');
});

/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/

Route::get('/page/{alias}', 'FrontController@page');
Route::get('/{useralias}/album/{id}','AlbumsController@getShow');
Route::controller('/{useralias}', 'ProfileController');
Route::controller('/', 'FrontController');
