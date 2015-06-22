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
		return View::make('content.front.messages.form',compact('user','messages'));
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

		Session::flash('success', 'Сообщение отправлено!');
		return Redirect::back();
	}

}