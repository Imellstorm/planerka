<?php

class MessageController extends BaseController {

	protected $rules = array(
		'user_id'	=> 'required',
		'text'		=> 'required',
	);
	protected $table_fields = array(
			'From'		=> 'from_name',
			'To'		=> 'to_name',
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
		$lang = Cookie::get('lang');
		if(!empty($lang)){
			App::setLocale($lang);
		}			
		$user = User::find($userId);
		if(empty($user)){
			App::abort(404);
		}	
		return View::make('content.front.messages.form',compact('user'));
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


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Redirect
	 */
	public function inboxDelete($id='')
	{
		$message = Message::find($id);
		if(empty($message) || $message->to != Auth::User()->id){
			App::abort(404);
		}

		if($message->from_del==1){
			Message::destroy($id);
		} else {
			$updateData['to_del'] = 1;
		}		

		if(isset($updateData)){			
			$message->update($updateData);
		}

		Session::flash('success', 'Сообщение удалёно!');
		return Redirect::back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Redirect
	 */
	public function outboxDelete($id='')
	{
		$message = Message::find($id);
		if(empty($message) || $message->from != Auth::User()->id){
			App::abort(404);
		}

		if($message->to_del==1){
			Message::destroy($id);
		} else {
			$updateData['from_del'] = 1;
		}		

		if(isset($updateData)){			
			$message->update($updateData);
		}

		Session::flash('success', 'Сообщение удалёно!');
		return Redirect::back();
	}

}