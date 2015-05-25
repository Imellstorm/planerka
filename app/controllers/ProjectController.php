<?php

class ProjectController extends BaseController {

	protected $table_fields = array(
	);

	protected $rules = array(
		'title'				=> 'required|max:256',
		'pro_only'			=> 'max:1'
	);

	public function getCreateform(){
		$roles = Role::lists('name','id');
		unset($roles[1]);
		unset($roles[2]);
		return View::make('content.front.projectform',compact('roles'));
	}

	public function postStore(){
		$validator = Validator::make(Input::all(), $this->rules);

		if ($validator->fails())
		{
			$errMess = '<div style="color:red">';
			foreach($validator->messages()->toArray() as $key=>$val){
				$errMess.= $val[0].'<br>';
			}
			$errMess.= '</div>';
			$view = View::make('content.front.messagebox',array('message'=>$errMess))->render();
        	return Redirect::back()->with('message', $view);
		} else {
			$model = new Project;
			$proOnly = Input::get('pro_only');

	        $model->title   			= Input::get('title');
	        $model->description   		= Input::get('description');
	        $model->budget   			= Input::get('budget');
	        $model->role_id   			= Input::get('role_id');
	        $model->term   				= Input::get('term');
	        $model->pro_only   			= $proOnly?$proOnly:'';

	        if(Input::hasFile('image')) {
				$image = Common_helper::fileUpload(Input::file('image'),'images/'.Auth::user()->alias);
				if(isset($image['path']) && !empty($image['path'])){
					$model->image = $image['path'];
					$thumb_path = 'uploads/images/'.Auth::user()->alias.'/thumb_'.$image['name'];
					if(Common_helper::getThumb($image['path'],$thumb_path,300,200)){
						$model->thumb = $thumb_path;
					};
				}
			}
        	$model->save();
		}
		$view = View::make('content.front.messagebox',array('message'=>'Мероприятие добавлено!'))->render();
        return Redirect::back()->with('message', $view);
	}
}