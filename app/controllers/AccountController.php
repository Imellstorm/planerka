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
		$notifications = $model->select('users.alias','user_info.*','notifications.*')
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
		$favorites = Favorites::select(DB::raw('COUNT('.DB::getTablePrefix().'reviews.id) as reviews'),DB::raw('COUNT('.DB::getTablePrefix().'users_to_project.id) as projects'),'users.alias','user_info.*')
			->leftjoin('user_info','user_info.user_id','=','favorites.selected_user_id')
			->leftjoin('users','users.id','=','favorites.selected_user_id')
			->leftjoin('reviews','reviews.to_user','=','favorites.selected_user_id')
			->leftjoin('users_to_project','users_to_project.user_id','=','favorites.selected_user_id')
			->where('favorites.user_id',Auth::user()->id)
			->where('users_to_project.status',6)
			->groupBy('favorites.id')
			->get();
		if(count($favorites)){
			foreach ($favorites as $key => $fav) {
				$fav->specializations = Specialization::where('user_id',$fav->user_id)->get();
				$fav->albums = Album::where('user_id',$fav->user_id)->get();
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

	/**
	 * Show Messages inbox page
	 *
	 * @return Response
	 */
	public function getMessagesinbox(){
		$model = new Message;
		$table_fields = array(
			'От кого'		=> 'from_name',
			'Отправлено'	=> 'created_at',
			'Статус'		=> 'readed'
		);	
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);

		$type="inbox";
        $messages = $model->getMessagesInbox($table_fields,$params,Auth::User()->id);
        $messagesContent = View::make('content.front.account.messages_inbox',compact('messages','type','table_fields'));
		return View::make('content.front.account.cont')->nest('content','content.front.account.messages_menu',compact('messagesContent'));
	}

	/**
	 * Show Messages outbox page
	 *
	 * @return Response
	 */
	public function getMessagesoutbox(){
		$model = new Message;
		$table_fields = array(
			'Кому'			=> 'to_name',
			'Отправлено'	=> 'created_at',
		);	
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);

		$type="outbox";
        $messages = $model->getMessagesOutbox($table_fields,$params,Auth::User()->id);
        $messagesContent = View::make('content.front.account.messages_outbox',compact('messages','type','table_fields'));
		return View::make('content.front.account.cont')->nest('content','content.front.account.messages_menu',compact('messagesContent'));
	}


	/**
	 * Show singl message page
	 *
	 * @return Response
	 */
	public function getMessage($id=''){
		$model = new Message;
        $message = $model->find($id);
        $userId = Auth::User()->id;      
        if(empty($message) || $message->to!=$userId && $message->from!=$userId){
        	return Redirect::to('/account/messages');
        }
        if($message->to==$userId){
        	$data['readed'] = 1;
        	$model->where('id',$id)->update($data);
    	}        
		return View::make('content.front.account.cont')->nest('content','content.front.account.message',compact('message'));
	}
}