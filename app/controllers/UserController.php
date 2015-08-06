<?php

class UserController extends BaseController {

	protected $rules = array(
		'username'	=> 'required|max:256|unique:users,username|alpha_dash',
		'alias'		=> 'required|max:256|unique:users,alias',
		'email'		=> 'required|max:256|email|unique:users,email',
		'password'	=> 'required|max:256|same:password_confirmation',
		'phone'		=> 'alpha_dash|max:32',
		'role'		=> 'max:9',
		'address'	=> 'max:256',
	);
	protected $table_fields = array(
			'Имя'			=> 'users.username',
			'Email'			=> 'users.email',
			'Создан'		=> 'users.created_at',
			'Город'			=> 'user_info.city',
			'Специализация'	=> 'roles.name',
			'Рейтинг'		=> 'user_info.rating',
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
		return View::make('content.admin.users.form',compact('roles_dd'));
	}

	/**
	 * Validate registration data
	 *
	 * @return Response
	 */
	public function postValidate(){
		$inputData = Input::all();
		$inputData['alias'] = Common_helper::generateAlias($inputData['username']);

		$validator = Validator::make($inputData, $this->rules);
		if ($validator->fails()){
			return Response::json($validator->messages());
		}
		if(!$this->checkCapcha()){
			return Response::json(array('captcha'=>'Неверная капча'));
		}
		$otherRoles = Role::where('type','другое')->get();
		$view = View::make('content.front.register_roles',compact('otherRoles'))->render();
		return Response::json(array('success'=>'success','view'=>$view));
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{
		$inputData = Input::all();
		$inputData['alias'] = Common_helper::generateAlias($inputData['username']);

		$validator = Validator::make($inputData, $this->rules);

		if ($validator->fails())
		{
			if($this->is_admin()){
				return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
			} else {
				return Response::json($validator->messages());
			}
		} else {	

			$user = new User;
			$rawRole = $inputData['role'];
			if(!$this->is_admin() && $rawRole!=1 || $this->is_admin()){
				$role = $rawRole;
			} else {
				return false;
			}
 
	        $user->username   	= $inputData['username'];
	        $user->alias   		= $inputData['alias'];
	        $user->email      	= $inputData['email'];
	        $user->role_id    	= $role;
	        $user->password   	= Hash::make($inputData['password']);
	        $user->onfront      = isset($inputData['onfront'])?$inputData['onfront']:0;

	        if($this->is_admin()){
				$randomStr = '1';
			} else {
				$randomStr = str_random(40);
				mail($user->email, 'Подтверждение Email', 'Для подтверждение email на сайте '.URL::to('/').' перейдите по ссылке '.URL::to('/').'/account/verifyemail/'.$randomStr, 'From: info@planerca.ru' );
			}
	        $user->email_verify	= $randomStr;

	        if(isset($inputData['socnet']) && isset($inputData['socid']) && isset($inputData['socimage'])){
		        $socNet = $inputData['socnet'];
				$socId = $inputData['socid'];
				$socImage = $inputData['socimage'];
		        if(!empty($socNet) && !empty($socId)){
		        	$user->socnet = $socNet;
		        	$user->socid  = $socId;
		        	$user->socimage  = $socImage;
		        }
		    }

	        if($this->is_admin() && $inputData['balance']){
				$user->balance = $inputData['balance'];
			}

        	$user->save();

        	$userInfo = new Userinfo;
        	$userInfo->user_id = $user->id;
        	$userInfo->save();

        	$specialization = new Specialization;
        	$specialization->user_id = $user->id;
        	$specialization->role_id = $role;
        	$specialization->save();
		}

		if(!Request::ajax()){
			Session::flash('success', 'Пользователь создан!');
			return Redirect::to('/admin/users');
		} else{
			$view = View::make('content.front.messagebox',array('message'=>'Спасибо за регистрацию. Вам на почту отправлено письмо с активацией.'))->render();
			return Response::json(array('success'=>'success','view'=>$view));
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

		$user = User::find($id);
		if(empty($user)){
			App::abort(404);
		}
		
		$this->rules['email'] = 'required|email|max:256|unique:users,email,'.$id;
		$this->rules['username'] = 'required|max:256|unique:users,username,'.$id;
		$this->rules['alias'] = 'required|max:256|unique:users,alias,'.$id;
		$this->rules['password'] = 'max:256|same:password_confirmation';

		$inputData = Input::all();
		$inputData['alias'] = Common_helper::generateAlias($user->username);

		$validator = Validator::make($inputData, $this->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$data = array(
		        'username'  	=> Input::get('username'),
		        'email'     	=> Input::get('email'),	
		        'alias'			=> $inputData['alias'],
		        'onfront'		=> Input::get('onfront')?Input::get('onfront'):0,	        
	        );	        
	        if(Input::get('password')){
	        	$data['password'] = Hash::make(Input::get('password'));
	        }

	        if($this->is_admin() && Input::get('role')){
				$data['role_id'] = Input::get('role');

				$specialization = Specialization::where('user_id',$user->id)->where('role_id',$user->role_id)->delete();
				$specialization = new Specialization;
	        	$specialization->user_id = $user->id;
	        	$specialization->role_id = $data['role_id'];
	        	$specialization->save();
			}

			if($this->is_admin() && Input::get('balance')){
				$data['balance'] = Input::get('balance');
			}

			if($this->is_admin() && Input::get('status')){
				$data['status'] = Input::get('status');
			}

			// if(!$this->is_admin() && $user->email!=Input::get('email')){
			// 	$randomStr = str_random(40);
			// 	mail($data['email'], 'Подтверждение Email', 'Для подтверждение email на сайте '.URL::to('/').' перейдите по ссылке '.URL::to('/').'/account/verifyemail/'.$randomStr );
			// 	$data['email_verify'] = $randomStr;
			// }

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
		Usersettings::where('user_id',$id)->delete();
		Userinfo::where('user_id',$id)->delete();
		User::destroy($id);
		Session::flash('success', 'Пользователь удалён!');
		return Redirect::to('admin/users');
	}

}