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
		$user = User::where('alias',$useralias)->first();
		$userinfo = Userinfo::where('user_id',$user->id)->first();
		$images = Image::where('album_id',$id)->get();
		$album = Album::where('user_id',$user->id)->where('id',$id)->first();
		if(!empty($album)){	
			return View::make('content.front.profile.album', compact('album','images','user','userinfo'));
		} else {
			App::abort(404);
		}
	}

	public function postUploadimage($albumId){
		$file = Input::file('file');
		if(!empty($file)){
	   		$dimensions = getimagesize($file);
	   		if($dimensions[0]<600 && $dimensions[1]<600){
	   			return Response::json('Размер изображения слишком мал', 400);
	   		}
	   	}
	    $image = Common_helper::fileUpload(Input::file('file'),'images/'.Auth::user()->alias);
	    if( isset($image['errors']) ) {
	    	return Response::json($image['errors'], 400);
        }
       	$thumb_big = 'uploads/images/'.Auth::user()->alias.'/thumb_big_'.$image['name'];
        Common_helper::getThumb($image['path'],$thumb_big,600,400);

        $thumb_small = 'uploads/images/'.Auth::user()->alias.'/thumb_small_'.$image['name'];
        Common_helper::getThumb($image['path'],$thumb_small,200,200);

    	$model = new Image;
    	$model->user_id 	= Auth::user()->id;
    	$model->album_id 	= $albumId;
    	$model->name 		= $image['name'];
    	$model->path 		= $image['path'];
    	$model->thumb_big 	= $thumb_big;
    	$model->thumb_small = $thumb_small;
    	$model->save();

    	return Response::json('success', 200);
	}

	public function getSetalbumcover($albumId,$imageId){
		$album = Album::find($albumId);
		$image = Image::where('id',$imageId)->where('album_id',$albumId)->first();
		if(empty($album) || empty($image)){
			App::abort(404);
		}
		$album->update(array('image'=>$image->thumb_small));
		return Redirect::back();
	}

	public function getAsd($albumId,$imageId){
		exit('123');
		$image = Image::find($imageId);
		// if(empty($image)){
		// 	App::abort(404);
		// }
		$image->delete();
		return Redirect::back();
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