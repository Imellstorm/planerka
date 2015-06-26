<?php

class AccountController extends BaseController {

	public function __construct(){
		parent::__construct();
		$this->getUserinfo();
	}

	/**
	 * Show Settings page
	 *
	 * @return Response
	 */
	public function getSettings(){
		$settings = Usersettings::where('user_id',Auth::user()->id)->first();
		return View::make('content.front.account.settings',compact('settings'));
	}

	/**
	 * Show Specialization page
	 *
	 * @return Response
	 */
	public function getSpecialization(){
		if(Auth::user()->role_id==2){
			App::abort(404);
		}
		$roles = Role::lists('name','id');
		if(!$this->is_admin()){
			unset($roles[1]);
		}	
		unset($roles[2]);

		$mainRole = Specialization::leftjoin('roles','roles.id','=','specializations.role_id')->where('user_id',Auth::user()->id)->where('role_id',Auth::user()->role_id)->first();
		$otheRoles = Specialization::leftjoin('roles','roles.id','=','specializations.role_id')->where('user_id',Auth::user()->id)->where('role_id','!=',Auth::user()->role_id)->get();
		$maxRoles = count($roles)-(count($otheRoles)+1);

		return View::make('content.front.account.specialization',compact('roles','maxRoles','mainRole','otheRoles','addRoles'));
	}

	/**
	 * Show Info page
	 *
	 * @return Response
	 */
	public function getInfo(){
		return View::make('content.front.account.info');
	}

	/**
	 * Show Orders page
	 *
	 * @return Response
	 */
	public function getProjects(){
		$model = new Project;
		if(Auth::user()->role_id==2){
			$projects = $model->getProjectsByUser(Auth::user()->id);
		} else {
			$projects = $model->getAcceptedProjects(Auth::user()->id);
		}
		return View::make('content.front.account.projects',compact('projects'));
	}

	/**
	 * Show Notifications page
	 *
	 * @return Response
	 */
	public function getNotifications(){
		$model = new Notifications;
		$notifications = $model->select('users.alias','users.online','user_info.*','notifications.*')
		->leftjoin('user_info','user_info.user_id','=','notifications.from_user')
		->leftjoin('users','users.id','=','notifications.from_user')
		->where('notifications.to_user',Auth::user()->id)
		->orderBy('notifications.id','DESC')
		->paginate(20);

		$model->where('to_user',Auth::user()->id)->update(array('readed'=>1));
		return View::make('content.front.account.notifications',compact('notifications'));
	}

	/**
	 * Show Messages page
	 *
	 * @return Response
	 */
	public function getMessages($userId=''){
		$model = new Message;
		if(empty($userId)){
			$dialogs = $model->getUserDialogs(Auth::user()->id);
			return View::make('content.front.account.dialogs',compact('dialogs'));
		}
		$messages = $model->getUserMessages(Auth::user()->id,$userId);
		$model->where('to',Auth::user()->id)->update(array('readed'=>1));
		return View::make('content.front.account.messages',compact('messages','userId'));
	}

	/**
	 * Show Favorites page
	 *
	 * @return Response
	 */
	public function getFavorites(){
		$favorites = Favorites::select(DB::raw('COUNT('.DB::getTablePrefix().'reviews.id) as reviews'),'users.alias','users.role_id','user_info.*','favorites.id as id')
			->leftjoin('user_info','user_info.user_id','=','favorites.selected_user_id')
			->leftjoin('users','users.id','=','favorites.selected_user_id')
			->leftjoin('reviews','reviews.to_user','=','favorites.selected_user_id')
			->where('favorites.user_id',Auth::user()->id)
			->groupBy('favorites.id')
			->get();
		if(count($favorites)){
			foreach ($favorites as $key => $fav) {
				$fav->specializations = Specialization::where('user_id',$fav->user_id)->join('roles','roles.id','=','specializations.role_id')->get();
				$fav->albums = Album::where('user_id',$fav->user_id)->get();
				if($fav->role_id==2){
					$fav->projects = Project::where('user_id',$fav->user_id)->count();
				} else {
					$fav->projects = Userstoproject::where('user_id',$fav->user_id)->where('status',6)->count();
				}
			}
		}
		return View::make('content.front.account.favorites',compact('favorites'));
	}

	/**
	 * Show Shop page
	 *
	 * @return Response
	 */
	public function getShop(){
		return View::make('content.front.account.shop');
	}

	/**
	 * Store Email verification data and send mail
	 *
	 */
	public function postSendemailverification(){
		$user = User::findOrFail(Auth::User()->id);
		$emailVerify = $user->email_verify;	

		if($emailVerify!='1'){	
			$randomStr = str_random(40);

			$data['email_verify'] = $randomStr;						
			$user->update($data);

			mail(Auth::User()->email, 'Подтверждение Email', 'Для подтверждение email на сайте '.URL::to('/').' перейдите по ссылке '.URL::to('/').'/account/verifyemail/'.$randomStr );			
		}
	}

	/**
	 * Verify User Email
	 *
	 */
	public function getVerifyemail($verificationCode=''){
		if(empty($verificationCode)){
			App::abort(404);
		}
		$user = User::where('email_verify',$verificationCode)->first();		
		if(!empty($user)){
			$data['email_verify'] = '1';
			$user->update($data);

			Auth::login($user);
			$view = View::make('content.front.messagebox',array('message'=>'Почта подтверждена. Спасибо!'))->render();
            return Redirect::to('/')->with('message', $view);
		} else {
			$view = View::make('content.front.messagebox',array('message'=>'Код верификации email неверен.'))->render();
			return Redirect::to('/')->with('message', $view);
		}
	}
}