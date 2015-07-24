<?php

class ProjectmessagesController extends BaseController {

	protected $rules = array(
		'text'				=> 'required',
		'term'				=> 'max:256',
		'albums'			=> 'max:256',
		'to_user'			=> 'required',
		'project_id'		=> 'required',
	);

	public function postStore(){
		if(!$this->isPro()){
			$date = new DateTime;
			$date->modify('-1 week');
			$formatted_date = $date->format('Y-m-d H:i:s');
			$projectsCount = Userstoproject::where('user_id',Auth::user()->id)->where('created_at','>=',$date)->count();
			if($projectsCount>=3){
				$view = View::make('content.front.messagebox',array('title'=>'Ошибка','message'=>'Превышен лимит ответов. Купите RPO аккаунт и отвечайте без ограничений!'))->render();
				return Redirect::back()->with('message', $view);
			}
		}

		$validator = Validator::make(Input::all(), $this->rules);
		if ($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$model = new Projectmessages;
			$projectId = Input::get('project_id');
			$albums = Input::get('albums');

			$model->from_user   	= Auth::user()->id;
			$model->to_user   		= Input::get('to_user')?Input::get('to_user'):'';
			$model->project_id		= $projectId;
	        $model->price   		= Input::get('price')?Input::get('price'):'';
	        $model->term   			= Input::get('term')?Input::get('term'):'';
	        $model->text   			= Input::get('text');
	        $model->albums   		= !empty($albums)?trim($albums,','):'';

        	$model->save();
		}

		$userId = Auth::user()->role_id!=2?Auth::user()->id:$model->to_user;
		$projectAssign = Userstoproject::where('project_id',$projectId)->where('user_id',$userId)->first();

		if(empty($projectAssign))	{
			$userstoproject = new Userstoproject;
			$userstoproject->user_id 	= Auth::user()->role_id!=2?Auth::user()->id:$model->to_user;
			$userstoproject->project_id = $projectId;
			$userstoproject->status 	= Auth::user()->role_id!=2?1:2;
			$userstoproject->new 		= 1;
			$userstoproject->save();

			$this->saveRating();
		}

		return Redirect::back();
	}

	private function saveRating(){
		$model = new Ratinghistory;

		$startToday = date('Y-m-d 00:00:00');
		$endToday = date('Y-m-d 23:59:59');
		$todayRatingCount = $model->where('user_id',Auth::user()->id)
			->where('type','projectsubscription')
			->whereBetween('created_at', array($startToday,$endToday))
			->count();
		
		if($todayRatingCount < 3){
			$model->user_id = Auth::user()->id;
			$model->user_type = 'performer';
			$model->amount = 1;
			$model->type = 'projectsubscription';
			$model->save();

			$userInfo = Userinfo::where('user_id',Auth::user()->id)->first();
			$newRating = $userInfo->rating+1;
			$userInfo->update(array('rating'=>$newRating));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$model = Video::find($id);
		if(!empty($model) && $this->is_owner($model->user_id)){
			Video::destroy($model->id);
			return Redirect::back();
		}
		return Redirect::back()->withErrors(array('Вы не можете удалить это видео!'));
	}

}