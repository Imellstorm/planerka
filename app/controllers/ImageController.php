<?php

class ImageController extends BaseController {

	public function postUploadimage($albumId){
		$album = Album::find($albumId);
		if(!$this->is_owner($album->user_id)){
			return Response::json('Вы не можете добавить фото не в свой альбом', 400);
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

				return Response::json('success');
			}
		}
		return Response::json('error');
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