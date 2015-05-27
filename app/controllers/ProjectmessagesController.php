<?php

class ProjectmessagesController extends BaseController {

	protected $rules = array(
		'text'				=> 'required',
		'term'				=> 'max:256',
		'albums'			=> 'max:256'
	);

	public function postStore(){
		$validator = Validator::make(Input::all(), $this->rules);

		if ($validator->fails())
		{
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
	        $model->albums   		= $albums?trim($albums,','):'';

        	$model->save();
		}

		$projectAssign = Userstoproject::where('project_id',$projectId)->where('user_id',Auth::user()->id)->first();
		if(Auth::user()->role_id!=2 && empty($projectAssign))	{
			$userstoproject = new Userstoproject;
			$userstoproject->user_id 	= Auth::user()->id;
			$userstoproject->project_id = $projectId;
			$userstoproject->status 	= 1;
			$userstoproject->save();
		}	

		return Redirect::back();
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