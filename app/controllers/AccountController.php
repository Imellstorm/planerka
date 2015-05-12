<?php

class AccountController extends BaseController {

	/**
	 * Show Settings page
	 *
	 * @return Response
	 */
	public function getSettings(){
		return View::make('content.front.account.settings');
	}

	/**
	 * Show Specialization page
	 *
	 * @return Response
	 */
	public function getSpecialization(){
		$roles = Role::lists('name','id');
		unset($roles[1]);
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
		$monthes = array(
		    1 => 'Января', 
		    2 => 'Февраля', 
		    3 => 'Марта', 
		    4 => 'Апреля',
		    5 => 'Мая', 
		    6 => 'Июня', 
		    7 => 'Июля', 
		    8 => 'Августа',
		    9 => 'Сентября', 
		    10 => 'Октября', 
		    11 => 'Ноября', 
		    12 => 'Декабря'
		);
		$userinfo = Userinfo::where('user_id',Auth::user()->id)->first();
		if(isset($userinfo->birthday) && !empty($userinfo->birthday)){
			$userinfo->birthday = date('j',$userinfo->birthday).' '.$monthes[(date('n',$userinfo->birthday))].' '.date('Y',$userinfo->birthday);
		}
		return View::make('content.front.account.info',compact('userinfo','monthes'));
	}

	/**
	 * Show Orders page
	 *
	 * @return Response
	 */
	public function getOrders(){
		return View::make('content.front.account.orders');
	}

	/**
	 * Show Notifications page
	 *
	 * @return Response
	 */
	public function getNotifications(){
		return View::make('content.front.account.notifications');
	}

	/**
	 * Show Messages page
	 *
	 * @return Response
	 */
	public function getMessages(){
		return View::make('content.front.account.messages');
	}

	/**
	 * Show Favorites page
	 *
	 * @return Response
	 */
	public function getFavorites(){
		return View::make('content.front.account.favorites');
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

	/**
	 * Show Funds page
	 *
	 * @return Response
	 */
	public function getFunds(){
		$subscribe = $this->checkSubscribe();
		$subscribe_price = Settings::first()->subscribe_price;
		if(Input::get('amount')){
			return View::make('content.front.account.cont')->nest('content','content.front.account.funds_step2');
		}
		return View::make('content.front.account.cont')->nest('content','content.front.account.funds_step1',compact('subscribe','subscribe_price'));
	}

	/**
	* Shop pay form
	*
	* @return Response
	*/
	public function postPay(){		
		$amount = Input::get('amount');
		$settings = Settings::first();	
		$private_key = $settings->liqpay_private_key;	//'HYrdcUWhXEuogBY2v40z2jroSfGApwVwQL8TDoW5';
		$public_key = $settings->liqpay_public_key;		//'i89897446364';

		$order = new Order;
				$order->user_id		= Auth::user()->id;
				$order->amount 		= $amount;
				$order->status		= 'not paid';
				$order->save();

		if(!empty($amount)){
			$data = array(
				'version' 		=> 3,
				'public_key'	=> $public_key,
				'amount'		=> $amount,
				'currency'		=> 'UAH',
				'description'	=> 'Пополнение счета FirmMarket',
				'order_id'		=> $order->id,
				'server_url'	=> URL::to('/').'/payprocess',
				'result_url'	=> URL::to('/').'/account/funds',
				'sandbox'		=> 1
			);
			$data = base64_encode(json_encode($data));
			$signature = base64_encode(sha1($private_key.$data.$private_key,1));

			$order->data = $data;
			$order->signature = $signature;
			$order->update();

			return View::make('content.front.account.cont')->nest('content','content.front.account.funds_step2',compact('amount','signature','data'));
		}
		return Redirect::Back()->withErrors(array('Введите сумму оплаты'));
	}


	/**
	* Collect cities for region (for ajax)
	*
	* @return Response
	*/
	public function getCitylist(){
		if(Request::ajax()){
			$locale = App::getLocale();
			$regionId = Request::get('regionId');
			$cityId = Request::get('cityid');
			if($locale=='ru'){
				$cities = array('0' => 'Select...') + City::where('region_id',$regionId)->lists('name','id');
			} else {
				$cities = array('0' => 'Select...') + City::where('region_id',$regionId)->lists('name_ukr','id');
			}
			return View::make('content.front.account.citylist',compact('cities','cityId'));
		}

	}

	/**
	* Buy account time action
	*
	* @return Redirect
	*/
	public function postBuysubscription(){
		$settings = Settings::first();
		$accountPrice = $settings->subscribe_price;
		$balance = Auth::User()->balance - $accountPrice;
		$subscribe = $this->checkSubscribe();

		if($subscribe){
			$time = strtotime('next month',strtotime(Auth::User()->expires));  //добавляем месяц к дате истечения подписки
			$date = date('Y-m-d H:i:s',$time);
		} else {
			$date = date('Y-m-d H:i:s', strtotime('+1 month'));	//добавляем месяц от текущей даты
		}

		if($balance >= 0){
			User::where('id', Auth::User()->id)->update(array(
				'balance' 	=> $balance,
				'expires'	=> $date,
			));
			Session::flash('success', 'Спасибо! Действие вашей учётной записи продлено на месяц');
			return Redirect::to('/account/funds');
		} else {
			return Redirect::to('/account/funds')->withErrors(array('Недостаточно средств, пополните счёт'));
		}
	}

	/**
	 * Show "set vip to post" page
	 *
	 * @return Response
	 */
	public function vipPost($postId='',$param=''){
		$post = Post::find($postId);

		if(empty($post) || $post->user_id!=Auth::User()->id){
			return Redirect::to('/account/posts')->withErrors(array('Неверный Id объявления'));
		}
		if($param=='region' || $param=='city'){
			$param;
		} else{
			$param='';
		}

		$model = new Vippost;
		$postDays = $model->where('post_id',$postId)->where('date','>=',date('Y-m-d'))->where('param',$param)->get();
		$settings = Settings::first();
		$busyDays = $model->getBusyDays($settings->vip_per_day,$param);
		foreach ($postDays as $val) {
			$daysPrep[$val->date] = $val->date;
		}
		foreach ($busyDays as $val) {
			if(!isset($daysPrep[$val->date])){
				$daysPrep[$val->date] = $val->date;
			}
		}
		if(!empty($daysPrep)){
			$daysPrep = array_values($daysPrep);	

			$bookedDays = '';
			$lastKey = count($daysPrep) - 1;			
			foreach($daysPrep as $key => $day){
				$bookedDays.='date.format() == "'.$day.'"';
				if($key != $lastKey){
					$bookedDays.=' || ';
				}
			}
		}
		$price = $this->getPrice($param);

		$postContent = View::make('content.front.account.post_vip', compact('postId','bookedDays','param','price'));
		return View::make('content.front.account.cont')->nest('content','content.front.account.posts_menu', compact('postContent'));
	}

	/**
	* Buy vip for post
	*
	* @return Redirect
	*/
	public function postBuyvip(){
		$model 	= new Vippost;
		$days 	= Input::get('days');
		$postId = Input::get('post_id');
		$param = Input::get('param');
		$price = $this->getPrice($param);

		$cost = count($days)*$price;
		$balance = Auth::User()->balance - $cost;
		if($balance >= 0){
			if(!empty($days) && !empty($postId)){
				$model->insertVipPosts($days,$postId,$param);
				User::where('id', Auth::User()->id)->update(array(
					'balance' 	=> $balance
				));
			}
			Session::flash('success', 'Спасибо! Ваше объявление будет показано в выбранные вами дни в VIP зоне.');
			return Redirect::to('/account/posts');
		} else {
			return Redirect::to('/account/posts')->withErrors(array('Недостаточно средств, пополните счёт'));
		}
	}

	private function getPrice($param){
		$settings = Settings::first();	
		if($param=='region'){
			$price = $settings->region_vip_price;
		} elseif($param=='city') {
			$price = $settings->city_vip_price;
		} else {
			$price = $settings->main_vip_price;
		}	
		return $price;
	}

	/**
	* Show comments page
	*
	* @return Response
	*/
	public function getComments(){
		$table_fields = array(
			'Отправлено'	=> 'created_at',
			'Объявление'	=> 'post_id'
		);	
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);
		$model = new Comment;
		$comments = $model->getUserComments(Auth::User()->id,$table_fields,$params);
		return View::make('content.front.account.cont')->nest('content','content.front.account.comments',compact('comments','table_fields'));
	}

}