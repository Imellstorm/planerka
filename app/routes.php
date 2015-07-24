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
Route::get('account/resendmailverify/{id}','AccountController@postSendemailverification');
Route::get('orders/success','OrderController@getSuccess');
Route::get('orders/fail','OrderController@getFail');
Route::controller('password', 'RemindersController');
Route::controller('blog', 'BlogController');


/*
|--------------------------------------------------------------------------
| For admin
|--------------------------------------------------------------------------
*/

Route::group(array('before' => 'is_admin_filter'), function() {	
	Route::get('admin', 'UserController@getIndex');
	Route::get('admin/orders/{id}', 'OrderController@getUserOrders');
	Route::get('/admin/rating/{id}', 'RatingController@ratingForm');
	Route::post('/admin/rating/store', 'RatingController@postStore');
	Route::controller('admin/users', 'UserController');
	Route::controller('admin/articles', 'ArticleController');
	Route::controller('admin/roles', 'RoleController');
	Route::controller('admin/menus', 'MenuController');
	Route::controller('admin/vote', 'VoteController');
	Route::controller('admin/blog/categories', 'BlogcategoriesController');
	Route::controller('admin/blog/subcategories', 'BlogsubcategoriesController');
});

/*
|--------------------------------------------------------------------------
| For registered users
|--------------------------------------------------------------------------
*/

Route::group(array('before' => 'auth'), function() {		
	Route::controller('account','AccountController');
	Route::controller('settings','SettingsController');
	Route::controller('userinfo','UserinfoController');	
	Route::controller('specializations','SpecializationsController');	
	Route::controller('album','AlbumsController');
	Route::controller('image','ImageController');
	Route::controller('video','VideoController');
	Route::controller('calendar','CalendarController');
	Route::controller('project','ProjectController');
	Route::controller('projectmessages', 'ProjectmessagesController');
	Route::controller('message', 'MessageController');
	Route::controller('review', 'ReviewController');
	Route::controller('favorites', 'FavoritesController');
	Route::post('vote/proccess', 'VoteController@postProccess');
	Route::get('/setoffline','BaseController@setOffline');
});

/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/
Route::get('/search', 'FrontController@search');
Route::get('/page/{alias}', 'FrontController@page');
Route::get('/{useralias}/album/{id}/{new?}','AlbumsController@getShow');
Route::controller('/{useralias}', 'ProfileController');
Route::controller('/', 'FrontController');
