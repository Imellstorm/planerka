<?php

class ReviewController extends BaseController {

	protected $rules = array(
		'text'			=> 'required',
		'to_user' 		=> 'required',
		'project_id'	=> 'required',
		'estimation'	=> 'required',
	);

	public function getForm($toUser,$projectId){
		$user = Userinfo::where('user_id',$toUser)->first();
		if(empty($user)){
			App::abort(404);
		}
		return View::make('content.front.reviews.form',compact('user','projectId'));
	}	

	public function postStore(){
		$validator = Validator::make(Input::all(), $this->rules);
		if ($validator->fails()){
			return Redirect::back()->withErrors($validator);
		} else {
			$toUser = Input::get('to_user');
			$projectId = Input::get('project_id');

			$user = User::find($toUser);
			$project = Project::find($projectId);
			if(empty($project)){					// проверка чтобы не писали отзывы в чужие проекты
				if(Auth::user()->role_id==2 && $project->user_id!=Auth::user()->id){
					App::abort(404);
				}
				if(Auth::user()->role_id!=2){
					$usersToProject = Userstoproject::where('project_id',$projectId)->where('user_id',Auth::user()->id)->first();
					if(empty($usersToProject) || $usersToProject->status!=6){
						App::abort(404);
					}
				}
			}

			$model = new Review;
			$model->from_user		= Auth::user()->id;
			$model->to_user 		= $toUser;
			$model->project_id 		= $projectId;
			$model->text 			= Input::get('text');
			$model->estimation		= Input::get('estimation');
			$model->save();

			$notify = new Notifications;
			$notify->from_user = Auth::user()->id;
			$notify->to_user = $model->to_user;
			$notify->text = 'О вас написали отзыв';
			$notify->link = $user->alias.'/reviews';
			$notify->save();

			$this->updateRating($model->estimation,$model->to_user);

		}
    	return Redirect::back();
	}

	private function updateRating($estimation,$user_id){
		switch ($estimation) {
			case 'good':
					$ratingAmount = 10;
				break;
			case 'normal':
					$ratingAmount = 4;
				break;
			case 'bad':
					$ratingAmount = -20;
				break;
			default:
					App::abort(404);
				break;
		}
		$user = User::find($user_id);

		$model = new Ratinghistory;
		$model->user_id = $user_id;
		$model->user_type = $user->role_id==2?'customer':'performer';
		$model->amount = $ratingAmount;
		$model->type = 'review';
		$model->save();

		$userInfo = Userinfo::where('user_id',$user_id)->first();
		$newRating = $userInfo->rating+$ratingAmount;
		$userInfo->update(array('rating'=>$newRating));
	}
}