<?php
class SiteSettingsController extends BaseController {
	function getEdit(){
		$settings = SiteSettings::first();
		return View::make('content.admin.sitesettings.form',compact('settings'));
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function putUpdate(){ 
		$model = SiteSettings::first();
		if(empty($model)){
		  App::abort(404);
		}
		$file = Input::file('cover');
		$data['cover_author'] = Input::get('cover_author');
		$data['slogan'] = Input::get('slogan');
		if(!empty($file)){
			$path = 'images/'.Auth::user()->alias;
			$image = Common_helper::fileUpload($file,$path);
			$data['main_cover'] = $image['path'];
		}
		$model->update( $data );
		return Redirect::back();
	}
}