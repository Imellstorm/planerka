<?php

class VideoController extends BaseController {

	public function postStore(){

		$video = Common_helper::fileUpload(Input::file('video'),'video/'.Auth::user()->alias,'','200000','mp4');
		if( isset($video['errors']) ) {
	    	return Redirect::back()->withErrors($video['errors']);
        }

    	$model = new Video;
    	$model->user_id 	= Auth::user()->id;
    	$model->name 		= $video['name'];
    	$model->path 		= $video['path'];
    	$model->save();

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