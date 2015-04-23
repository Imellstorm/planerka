<?php

class UserController extends BaseController {

	protected $rules = array(
		'username'	=> 'required|max:256',
		'email'		=> 'required|email|unique:users,email|max:256',
		'password'	=> 'required|same:password_confirmation|max:256',
		'phone'		=> 'alpha_dash|max:32',
		'role'		=> 'max:1',
		'address'	=> 'max:256',
	);
	protected $table_fields = array(
			'Имя'		=> 'username',
			'Email'		=> 'email',
			'Создан'	=> 'created_at',
			'Изменён'	=> 'updated_at',
			'Статус'	=> 'roles.name',
			'Баланс'	=> 'balance',
		);	

	/**
	* Display a listing of users
	*
	* @return Response
	*/
	public function getIndex()
	{
		$model = new User;
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);
		$table_fields = $this->table_fields;

        $users = $model->getUsers($table_fields,$params);

		return View::make('content.admin.users.index', compact('users','table_fields'));
	}

	/**
	 * Show the form for creating a new user
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		$roles_dd = Role::lists('name','id');
		$user_status = Userstatus::lists('name','id');
		return View::make('content.admin.users.form',compact('roles_dd','user_status'));
	}


	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{
		if(!$this->is_admin()){
			$this->rules['license_agreement'] = 'required';
		}
		$validator = Validator::make(Input::all(), $this->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
		} else {
			if(!$this->is_admin() && !$this->checkCapcha()){
				return Redirect::back()->withErrors('Неверная капча')->withInput(Input::except('password'));
			}

			$user = new User;

			if($this->is_admin() && Input::get('role')){
				$role = Input::get('role');
			} else {
				$role = 3;
			}

			if($this->is_admin() && Input::get('status')){
				$status = Input::get('status');
			} else {
				$status = 1;
			}

			$randomStr = str_random(40);
 
	        $user->username   	= Input::get('username');
	        $user->email      	= Input::get('email');
	        $user->role_id    	= $role;
	        $user->status    	= $status;
	        $user->password   	= Hash::make(Input::get('password'));
	        $user->address 	  	= Input::get('address')?Input::get('address'):'';	        
	        $user->phone 	  	= Input::get('phone')?Input::get('phone'):'';
	        $user->legal_form 	= Input::get('legal_form');
	        $user->email_verify	= $randomStr;

	        if($this->is_admin() && Input::get('balance')){
				$user->balance = Input::get('balance');
			}

        	$user->save();
		}

		mail($user->email, 'Подтверждение Email', 'Для подтверждение email на сайте '.URL::to('/').' перейдите по ссылке '.URL::to('/').'/account/verifyemail/'.$randomStr );

		Session::flash('success', 'Пользователь создан! На ваш почтовый ящик выслано письмо с инструкцией по активации');
		if($this->is_admin()){
			return Redirect::to('/admin/users');
		} else{
			return Redirect::to('/');
		}
	}

	private function checkCapcha(){
		include_once $_SERVER['DOCUMENT_ROOT'] . '/assets/packs/securimage/securimage.php';
		$securimage = new Securimage();
		if ($securimage->check($_POST['captcha_code']) == false) {
			return false;
		}
		return true;
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$user = User::find($id);
		if(!empty($user)){
			$roles_dd = Role::lists('name','id');
			$user_status = Userstatus::lists('name','id');
			return View::make('content.admin.users.form', compact('user','roles_dd','user_status'));
		} else {
			App::abort(404);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function putUpdate($id)
	{
		if(!Auth::check() || Auth::User()->id!=$id && !$this->is_admin()){
			return Redirect::to('/')->withErrors('У вас нет прав для данного действия!');
		}

		$user = User::findOrFail($id);
		
		$this->rules['email'] = 'required|email|max:256|unique:users,email,'.$id;
		$this->rules['password'] = 'max:256|same:password_confirmation';
		$validator = Validator::make($data = Input::all(), $this->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$data = array(
		        'username'  	=> Input::get('username'),
		        'email'     	=> Input::get('email'),		        
		        'address' 		=> Input::get('address'),
		        'phone' 		=> Input::get('phone'),
		        'legal_form'	=> Input::get('legal_form'),
	        );	        
	        if(Input::get('password')){
	        	$data['password'] = Hash::make(Input::get('password'));
	        }

	        if($this->is_admin() && Input::get('role')){
				$data['role_id'] = Input::get('role');
			}

			if($this->is_admin() && Input::get('balance')){
				$data['balance'] = Input::get('balance');
			}

			if($this->is_admin() && Input::get('status')){
				$data['status'] = Input::get('status');
			}

			if(!$this->is_admin() && $user->email!=Input::get('email')){
				$randomStr = str_random(40);
				mail($data['email'], 'Подтверждение Email', 'Для подтверждение email на сайте '.URL::to('/').' перейдите по ссылке '.URL::to('/').'/account/verifyemail/'.$randomStr );
				$data['email_verify'] = $randomStr;
			}

        	$user->update($data);
		}
		Session::flash('success', 'Данные пользователя обновлены!');

		if($this->is_admin()){
			return Redirect::to('admin/users');
		} else {
			return Redirect::to('/account');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteDestroy($id)
	{
		User::destroy($id);
		Session::flash('success', 'Пользователь удалён!');
		return Redirect::to('admin/users');
	}

	/**
	 * Update user settungs
	 *
	 * @return Redirect
	 */
	public function updateSettings()
	{
		$get_mail = Input::get('get_mail');
		$user = User::find(Auth::User()->id);		
		$data['get_mail'] = empty($get_mail)?0:1;
		$user->update($data);
		Session::flash('success', 'Настройки обновлены!');
		return Redirect::back();
	}
}