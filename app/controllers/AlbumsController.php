<?php

class AlbumsController extends BaseController {

	public function __construct(){
		parent::__construct();
	}


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
		if(empty($user)){
			App::abort(404);
		}
		$this->getUserinfo($user->id);
		$images = Image::select('images.*',DB::raw('count('.DB::getTablePrefix().'image_likes.id) as likes'))
					->leftjoin('image_likes','image_likes.image_id','=','images.id')
					->where('album_id',$id)
					->groupby('images.id')
					->get();
		$album = Album::where('user_id',$user->id)->where('id',$id)->first();
		if(!empty($album)){	
			return View::make('content.front.profile.album', compact('album','images','user'));
		} else {
			App::abort(404);
		}
	}

	public function getSetalbumcover($albumId,$imageId){
		$album = Album::find($albumId);
		if(!$this->is_owner($album->user_id)){
			App::abort(404);
		}
		$image = Image::where('id',$imageId)->where('album_id',$albumId)->first();
		if(empty($album) || empty($image)){
			App::abort(404);
		}
		$album->update(array('image'=>$image->thumb_small));
		return Redirect::back();
	}

	public function getSetprofilecover($imageId){
		$image = Image::find($imageId);
		if(empty($image) || !$this->is_owner($image->user_id)){
			App::abort(404);
		}
		$model = Userinfo::where('user_id',$image->user_id)->first();
		$model->update(array('cover'=>$image->path));
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

	public function getDelete($id){
		$album = Album::find($id);
		if(empty($album) || !$this->is_owner($album->user_id)){
			App::abort(404);
		}
		Image::where('album_id',$album->id)->delete();
		$album->delete();
		return Redirect::to('/'.Auth::user()->alias.'/photo');
	}
}