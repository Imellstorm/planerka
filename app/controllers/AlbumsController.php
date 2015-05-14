<?php

class AlbumsController extends BaseController {

	protected $rules = array(
		'name'	=> 'required|max:256',
	);

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($useralias,$id)
	{
		$album = Album::find($id);
		$userinfo = Userinfo::where('user_id',Auth::user()->id)->first();
		if(!empty($album)){	
			return View::make('content.front.profile.album', compact('album','userinfo','useralias'));
		} else {
			App::abort(404);
		}
	}

	public function postUploadimage(){
		$file = Input::file('file');
	    //$extension = File::extension($file->getClientOriginalName());

	    $upload_success = Input::file('file')->move('uploads', $file->getClientOriginalName());
	    if( $upload_success ) {
        	return Response::json('success', 200);
        } else {
        	return Response::json('error', 400);
       	} 
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{	
		$validator = Validator::make(Input::all(), $this->rules);
		if ($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$model = new Album;
			$model->user_id		= Auth::user()->id;
			$model->name 		= Input::get('name');
			$model->description = Input::get('description');
			$model->save();
		}	
        return Redirect::to('/'.Auth::user()->alias.'/album/'.$model->id);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function putUpdate($id)
	{ 
		$model = Usersettings::find($id);
		if(empty($model)){
			App::abort(404);
		}
		
		$validator = Validator::make($data = Input::all(), $this->rules);

		if ($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput(Input::except('newpass','passconf','oldpass'));
		} else {
			$data = array(
		        'adminmail'  	=> Input::get('adminmail'),
		        'blogmail'   	=> Input::get('blogmail'),		        
		        'privatemail' 	=> Input::get('privatemail'),
		        'projectsmail' 	=> Input::get('projectsmail'),
	        );	        
        	$model->update($data);

        	if(!$this->updatePassword()){
        		return Redirect::back()->withErrors(array('oldpassword'=>'Неверный старый пароль'));
        	};
		}
		$view = View::make('content.front.messagebox',array('message'=>'Настройки обновлены!'))->render();
        return Redirect::back()->with('message', $view);
	}

	public function getDelete($id){
		$album = Album::find($id);
		if(empty($album)){
			App::abort(404);
		}
		$album->delete();
		return Redirect::to('/'.Auth::user()->alias.'/photo');
	}
}