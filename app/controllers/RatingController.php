<?php

class RatingController extends BaseController {

	protected $rules = array(
		'amount'	=> 'required|alpha_dash',
		'userId'	=> 'required',
	);

	public function ratingForm($userId){
		return View::make('content.admin.rating.form',compact('userId'));
	}

	public function postStore(){

		$validator = Validator::make(Input::all(), $this->rules);
		if ($validator->fails()){
			return Redirect::back()->withErrors($validator);
		}
		$userId = Input::get('userId');
		$model = Userinfo::where('user_id',$userId)->first();
		if(empty($model)){
			App::abort(404);
		}
		$amount = (int)Input::get('amount');
		$newRating = $model->rating+$amount;
		$model->update(array('rating'=>$newRating));

		$reason = Input::get('reason');
		if(!empty($reason)){
			$notify = new Notifications;
			$notify->from_user = Auth::user()->id;
			$notify->to_user = $userId;
			$notify->text = $reason;
			$notify->link = '';
			$notify->save();
		}
    	return Redirect::back();
	}

}