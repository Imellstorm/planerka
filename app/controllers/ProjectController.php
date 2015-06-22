<?php

class ProjectController extends BaseController {

	protected $table_fields = array(
	);

	protected $rules = array(
		'title'		=> 'required|max:256',
		'pro_only'	=> 'max:1',
		'status'	=> 'max:32',
		'city'		=> 'max:256',
		'phone'		=> 'max:64'	
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
			if(!empty($projectMessages)){
				foreach ($projectMessages as $mess){
					if(!empty($mess->albums)){
						$albumsIds = explode(',',$mess->albums);
						foreach ($albumsIds as $albumId) {
							$album = Album::find($albumId);
							if(!empty($album)){
								$albums[$mess->id][] = $album;
							}
						}
					}
				}
			}
			$model->where('to_user',Auth::user()->id)->where('project_id',$id)->update(array('readed'=>1));
			return View::make('content.front.projects.singl',compact('project','userDate','projectAssign','projectMessages','albums'));
		}

		$usersToProject = Userstoproject::select('user_info.*','users_to_project.*','users_to_project.id as users_to_project_id','users.*')
				->leftjoin('user_info','user_info.user_id','=','users_to_project.user_id')
				->leftjoin('users','users.id','=','users_to_project.user_id')
				->where('users_to_project.project_id',$id)
				->paginate(20);

		$existReview = Review::where('from_user',Auth::user()->id)->where('project_id',$project->project_id)->first();
		$existPerformer = Userstoproject::where('users_to_project.project_id',$id)->where('status','>',2)->first();

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
		return View::make('content.front.projects.singl',compact('project','usersToProject','existPerformer','existReview'));
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
		$model->where('to_user',Auth::user()->id)->where('project_id',$projectId)->update(array('readed'=>1));
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

		if ($validator->fails()){
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
			//Если заказчик заказывает исполнителя напрямую
			$performer = Input::get('performer');
			if(!empty($performer)){
				$model->city 	= Input::get('city');
				$model->date 	= !empty($model->date)?date('Y-m-d',strtotime(Input::get('date'))):date('Y-m-d');
				$model->phone 	= Input::get('phone');
				$model->status 	= 'private';
			}

        	$model->save();
		}

		if(!empty($performer)){
			$projmess = new Projectmessages;
			$projmess->from_user   	= Auth::user()->id;
			$projmess->to_user   	= $performer;
			$projmess->project_id	= $model->id;
	        $projmess->price   		= $model->budget;
	        $projmess->term   		= $model->term;
	        $projmess->text   		= $model->description;
        	$projmess->save();

        	$userstoproject = new Userstoproject;
			$userstoproject->user_id 	= $performer;
			$userstoproject->project_id = $model->id;
			$userstoproject->status 	= 2;
			$userstoproject->save();
			$view = View::make('content.front.project_created_modal')->render();
		} else {
			$view = View::make('content.front.messagebox',array('message'=>'Мероприятие добавлено!'))->render();
		}

		
        return Redirect::back()->with('message', $view);
	}

	public function getChangestatus($id='',$status=''){
		if(empty($id) || empty($status) || $status==1){
			App::abort(404);
		}
		$usersToProject = Userstoproject::find($id);
		if(empty($usersToProject)){
			App::abort(404);
		}
		$project = Project::find($usersToProject->project_id);
		if(empty($project)){
			App::abort(404);
		}
		$currentUser = Auth::user();
		$text = '';

		//для автора проекта
		if($status==2 && $project->user_id == $currentUser->id){
			$usersToProject->update(array('status'=>2)); //исполнитель принят
			$text = 'Ваше участие в проекте подтверждено';
			$userId = $usersToProject->user_id;
		}
		if($status==4 && $project->user_id == $currentUser->id){
			$usersToProject->update(array('status'=>4)); //исполнитель не принят
			$text = 'Вам отказали в участии в проекте';
			$userId = $usersToProject->user_id;
		}

		//для подписавшегося исполнителя
		if($status==3 && $usersToProject->user_id == $currentUser->id){
			$usersToProject->update(array('status'=>3)); //подтвердил участие в проекте
			$text = 'Получено согласие на участие в проекте';
			$userId = $project->user_id;
		}
		if($status==5 && $usersToProject->user_id == $currentUser->id){
			$usersToProject->delete();					//отказался от проекта
			Projectmessages::where('project_id',$usersToProject->project_id)
							->where('to_user',$currentUser->id)
							->orWhere('from_user',$currentUser->id)
							->delete(); 
			$text = 'Отказ от проекта';
			$userId = $project->user_id;
		}
		if($status==6 && ($usersToProject->user_id == $currentUser->id || $project->user_id == $currentUser->id)){
			$usersToProject->update(array('status'=>6)); //подтвердил участие в проекте
			$text = 'Проект завершен';
			if($usersToProject->user_id == $currentUser->id){
				$userId = $project->user_id;
			} else {
				$userId = $usersToProject->user_id;
			}
			$project->update(array('closed'=>1));
		}

		$notify = new Notifications;
		$notify->from_user = Auth::user()->id;
		$notify->to_user = $userId;
		$notify->text = $text;
		$notify->link = 'project/singl/'.$project->id;
		$notify->save();

		return Redirect::back();
	}

	public function getInviteperformer($userId=''){
		if(empty($userId)){
			App::abort(404);
		}
		$roles = Role::lists('name','id');
		unset($roles[1]);
		unset($roles[2]);
		return View::make('content.front.projects.inviteperformer',compact('userId','roles'));
	}
}