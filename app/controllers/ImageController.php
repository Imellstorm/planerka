<?php

class ImageController extends BaseController {

	public function postUploadimage($albumId){
		$album = Album::find($albumId);
		if(!$this->is_owner($album->user_id)){
			return Response::json('Вы не можете добавить фото не в свой альбом', 400);
		}
		if(!$this->isPro()){
			$date = new DateTime;
			$date->modify('-1 week');
			$formatted_date = $date->format('Y-m-d H:i:s');
			$uploadsCount = Image::where('user_id',Auth::user()->id)->where('created_at','>=',$date)->count();
			if($uploadsCount>10){
				return Response::json('Превышен лимит загрузок', 400);
			}
		}

		$file = Input::file('file');

		if(!empty($file)){
	   		$dimensions = getimagesize($file);
	   		if($dimensions[0]<600 && $dimensions[1]<600){
	   			return Response::json('Размер изображения слишком мал', 400);
	   		}
	   	}
	    $image = Common_helper::fileUpload(Input::file('file'),'images/'.Auth::user()->alias);
	    if( isset($image['errors']) ) {
	    	return Response::json('Ошибка при загрузке фото'/*$image['errors']*/, 400);
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

	public function postUploadpostimage(){
		$postId = (int)Input::get('post_id');
		$post = Blogpost::where('id',$postId)->first();
		if(Auth::check() && !empty($post) && $this->is_owner($post->user_id)){
			$image = Common_helper::fileUpload(Input::file('file'),'images/'.Auth::user()->alias);
		    if( isset($image['errors']) ) {
		    	return Response::json('Ошибка при загрузке фото', 400);
	        }
	        $thumb = 'uploads/images/'.Auth::user()->alias.'/thumb_'.$image['name'];
        	Common_helper::getThumb($image['path'],$thumb,200,200);
	    	$model = new Blogimage;
	    	$model->user_id 	= Auth::user()->id;
	    	$model->path 		= $image['path'];
	    	$model->thumb 		= $thumb;
	    	$model->post_id 	= $postId;
	    	$model->save();

	    	return Response::json('success', 200);        	
		}
	}

	public function postLike(){
		$imageId = Input::get('imageid');
		$model = new Imagelikes;
		$existLike = $model->where('user_id',Auth::user()->id)->where('image_id',$imageId)->first();
		if(empty($existLike)){
			$model->user_id = Auth::user()->id;
			$model->image_id = $imageId;
			$model->save();

			$image = Image::leftjoin('users','users.id','=','images.user_id')->where('images.id',$imageId)->first();
			if(!empty($image)){
				$notify = new Notifications;
				$notify->from_user = Auth::user()->id;
				$notify->to_user = $image->user_id;
				$notify->text = 'Вашу фотографию оценили';
				$notify->link = $image->alias.'/album/'.$image->album_id;
				$notify->image = $image->thumb_small;
				$notify->save();

				$likesCount = $model->where('image_id',$imageId)->count();
				if($likesCount%20==0){
					$this->saveRating($image);
				}	

				return Response::json('success');
			}
		}
		return Response::json('error');
	}

	private function saveRating($image){
		$model = new Ratinghistory;

		$model->user_id = $image->user_id;
		$model->user_type = $image->role_id==2?'customer':'performer';
		$model->amount = 1;
		$model->type = 'imagelike';
		$model->save();

		$userInfo = Userinfo::where('user_id',$image->user_id)->first();
		$newRating = $userInfo->rating+1;
		$userInfo->update(array('rating'=>$newRating));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$model = Image::find($id);
		if(!empty($model) && $this->is_owner($model->user_id)){
			Image::destroy($model->id);
			return Redirect::back();
		}
		return Redirect::back()->withErrors(array('Вы не можете удалить это видео!'));
	}

}