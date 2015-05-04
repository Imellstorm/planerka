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

//Route::post('/comments/ajaxupdate','CommentController@postAjaxupdate');

Route::get('/users/getotherroles','UserController@getOtherRoles');

//Route::get('registration','AccountController@getRegister');
Route::get('account/verifyemail/{data}','AccountController@getVerifyemail');

Route::controller('password', 'RemindersController');

//Route::controller('/cron', 'CronController');

/*
|--------------------------------------------------------------------------
| For admin
|--------------------------------------------------------------------------
*/

Route::group(array('before' => 'is_admin_filter'), function() {	
	Route::get('admin', 'UserController@getIndex');
	Route::get('admin/comments', 'CommentController@getIndex');
	Route::get('admin/orders/{id}', 'OrderController@getUserOrders');
	Route::controller('admin/users', 'UserController');
	Route::controller('admin/posts', 'PostController');
	Route::controller('admin/articles', 'ArticleController');
	Route::controller('admin/roles', 'RoleController');
	Route::controller('admin/licenses', 'LicenseController');
	Route::controller('admin/ownerships', 'OwnershipController');
	Route::controller('admin/user_status', 'UserstatusController');
	Route::controller('admin/settings', 'SettingsController');
	Route::controller('admin/menus', 'MenuController');
});

/*
|--------------------------------------------------------------------------
| For registered users
|--------------------------------------------------------------------------
*/

Route::group(array('before' => 'auth'), function() {
	
	//Route::controller('comments','CommentController');

	//Route::post('post/store','PostController@postStore');
	//Route::get('post/delete/{id}','PostController@deleteDestroy');
	//Route::put('post/update/{id}','PostController@putUpdate');

	//Route::get('account/message/inbox/delete/{id}','MessageController@inboxDelete');
	//Route::get('account/message/outbox/delete/{id}','MessageController@outboxDelete');
	//Route::controller('message','MessageController');

	//Route::post('user/settings/update/','UserController@updateSettings');

	//Route::get('account/messages/outbox','AccountController@getMessagesoutbox');
	//Route::get('account/messages/inbox','AccountController@getMessagesinbox');

	//Route::get('account/posts/create','AccountController@createPost');
	//Route::get('account/posts/edit/{id}','AccountController@editPost');
	//Route::get('account/posts/vip/{id}/{param}','AccountController@vipPost');
	
	//Route::post('account/funds/step2','AccountController@postPay');

	//Route::get('account','AccountController@getUserinfo');		
	Route::controller('account','AccountController');	
});

/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/
//Route::post('payprocess','PayController@Payprocess');
//Route::get('/news/{id}', 'FrontController@getOnenews');
//Route::get('/changelang/{lang}', 'FrontController@changeLanguage');
//Route::get('/changecur/{cur}', 'FrontController@changeCurrency');
Route::get('/page/{alias}', 'FrontController@page');
Route::controller('/', 'FrontController');
