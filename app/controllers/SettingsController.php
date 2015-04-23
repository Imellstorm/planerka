<?php

class SettingsController extends BaseController {

	protected $rules = array(
		'subscribe_price'		=> 'required',
		'main_vip_price'		=> 'required',
		'region_vip_price'		=> 'required',
		'city_vip_price'		=> 'required',
		'liqpay_public_key'		=> 'required|max:64',
		'liqpay_private_key'	=> 'required|max:128',
	);


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit()
	{
		$settings = Settings::first();
		if(!empty($settings)){
			return View::make('content.admin.settings.form', compact('settings'));
		} else {
			App::abort(404);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function putUpdate($id)
	{
		$model = Settings::find($id);
		if(empty($model)){
			App::abort(404);
		}
		
		$validator = Validator::make($data = Input::all(), $this->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$data = array(
		        'subscribe_price'  		=> Input::get('subscribe_price'),
		        'main_vip_price'      	=> Input::get('main_vip_price'),
		        'region_vip_price'		=> Input::get('region_vip_price'),	
		        'city_vip_price'		=> Input::get('city_vip_price'),
		        'post_keep_front'		=> Input::get('post_keep_front'),
		        'post_keep_account'		=> Input::get('post_keep_account'),
		        'liqpay_public_key'		=> Input::get('liqpay_public_key'),
		        'liqpay_private_key'	=> Input::get('liqpay_private_key'),
		        'vip_per_day'			=> Input::get('vip_per_day'),	        
	        );	        

        	$model->update($data);
		}
		Session::flash('success', 'Данные обновлены!');

		return Redirect::to('admin/settings/edit');
	}

}