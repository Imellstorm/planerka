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
		if(!empty($file)){
			$path = 'images/'.Auth::user()->alias;
			$image = Common_helper::fileUpload($file,$path);
			$model->update(array('main_cover'=>$image['path']));
		}
		return Redirect::back();
	}
}