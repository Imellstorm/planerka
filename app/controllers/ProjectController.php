<?php

class ProjectController extends BaseController {

	protected $table_fields = array(
	);

	protected $rules = array(
		'title'				=> 'required|max:256',
		'pro_only'			=> 'max:1'
	);

	public function getSingl($id){
		$model = new Project;
		$project = $model->getProject($id);
		if(empty($project)){
			App::abort(404);
		}

		$projectAssign = false;
		if(Auth::user()->role_id!=2){
			$projectAssign = Userstoproject::where('user_id',Auth::user()->id)->where('project_id',$id)->first();
			$model = new Projectmessages;
			$projectMessages = $model->getProjectMessagesByUser($id,Auth::user()->id);
			return View::make('content.front.projects.singl',compact('project','userDate','projectAssign','projectMessages'));
		}

		$usersToProject = Userstoproject::leftjoin('user_info','user_info.user_id','=','users_to_project.user_id')
				->leftjoin('users','users.id','=','users_to_project.user_id')
				->where('users_to_project.project_id',$id)
				->paginate(20);

		if(!empty($usersToProject)){
			foreach ($usersToProject as $key => $val) {
				$model = new Projectmessages;
				$messages = $model->getProjectMessagesByUser($id,$val->user_id,true);	
				if(!empty($messages)){
					$val->mainMessage = array_pop($messages);
					if(!empty($val->mainMessage['albums'])){
						$albumsIds = explode(',',$val->mainMessage['albums']);
						$val->albums = DB::table('albums')->whereIn('id', $albumsIds)->get();
					}
				}
			}
		}
		return View::make('content.front.projects.singl',compact('project','usersToProject'));
	}

	public function getUsermassages($userId='',$projectId=''){
		if(empty($userId) || empty($projectId)){
			App::abort(404);
		}
		$project = Project::select('*','projects.id as project_id')->find($projectId);
		if(empty($project) || !$this->is_owner($project->user_id)){
			App::abort(404);
		}
		$model = new Projectmessages;
		$messages = $model->getProjectMessagesByUser($projectId,$userId);	
		return View::make('content.front.projects.usermassages',compact('messages','project','userId'));
	}

	public function getList(){
		$model = new Project;
		$projects = $model->getAllProjects();
		return View::make('content.front.projects.list',compact('projects'));
	}

	public function getCreate(){
		$roles = Role::lists('name','id');
		unset($roles[1]);
		unset($roles[2]);
		return View::make('content.front.projects.form',compact('roles'));
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
	        $model->user_id				= Auth::user()->id;
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