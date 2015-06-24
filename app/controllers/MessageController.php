<?php

class MessageController extends BaseController {

	protected $rules = array(
		'user_id'	=> 'required',
		'text'		=> 'required',
	);
	protected $table_fields = array(
			'От кого'	=> 'from_name',
			'Кому'		=> 'to_name',
			'Создан'	=> 'created_at',
			'Прочитано'	=> 'readed',
		);	


	/**
	 * Show the form for creating a new message
	 *
	 * @return Response
	 */
	public function getCreate($userId='')
	{			
		$user = User::find($userId);
		if(empty($user)){
			App::abort(404);
		}
		$messages = Message::select('users.alias','users.online','user_info.*','messages.*')
							->leftjoin('user_info','user_info.user_id','=','messages.from')
							->leftjoin('users','users.id','=','user_info.user_id')
							->where('from',Auth::user()->id)
							->where('to',$userId)
							->orWhere('to',Auth::user()->id)
							->where('from',$userId)
							->get();
		Message::where('to',Auth::user()->id)->where('from',$userId)->update(array('readed'=>1));
		return View::make('content.front.messages.form',compact('user','messages'));
	}

	public function getMessageblock(){
		$message = new StdClass;
		$userInfo = Userinfo::where('user_id',Auth::user()->id)->first();
		if(!empty($userInfo)){
			$message->name = $userInfo->name;
			$message->surname = $userInfo->surname;
			$message->city = $userInfo->city;
		} else {
			$message->city = '';
		}
		$message->user_id = Auth::user()->id;
		$message->alias = Auth::user()->alias;
		$message->online = 1;		
		$message->created_at = date('Y-m-d H:i:s');
		$message->text = Input::get('text');

		return View::make('content.front.messages.messageblock',compact('message'));
	}


	/**
	 * Store a newly created message in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{
		$validator = Validator::make(Input::all(), $this->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
		} else {
			$userId = Input::get('user_id');
			$user = User::find($userId);
			if(empty($user)){
				App::abort(404);
			}	
			$message = new Message;
 
 			$message->from = Auth::User()->id;
 			$message->from_name = Auth::User()->username;
	        $message->to = $user->id;
	        $message->to_name = $user->username;
	        $message->text = Input::get('text');

        	$message->save();
		}

		if (Request::ajax()){
			return 'success';
		}
		Session::flash('success', 'Сообщение отправлено!');
		return Redirect::back();
	}

}