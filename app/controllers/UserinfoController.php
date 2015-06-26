<?php

class UserinfoController extends BaseController {

	protected $rules = array(
		'name'				=> 'max:128',
		'surname'			=> 'max:128',
		'city'				=> 'max:128',
		'birthday'			=> '',
		'gender'			=> 'max:16',
		'phone'				=> 'max:64',
		'biography'			=> '',
		'additional_email'	=> 'max:128|email',
		'site'				=> 'max:128',
		'city_departure'	=> 'max:1',
		'country_departure'	=> 'max:1',
		'avatar'			=> '',
	);



	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{
		$validator = Validator::make(Input::all(), $this->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();;
		} else {
			$model = new Userinfo;
			$city_departure = Input::get('city_departure');
			$country_departure = Input::get('country_departure');

			$model->user_id				= Auth::user()->id;
	        $model->name   				= Input::get('name');
	        $model->surname   			= Input::get('surname');
	        $model->city   				= Input::get('city');
	        $model->birthday   			= $this->getTime(Input::get('birthday'));
	        $model->gender   			= Input::get('gender');
	        $model->phone   			= Input::get('phone');
	        $model->biography   		= Input::get('biography');
	        $model->additional_email   	= Input::get('additional_email');
	        $model->site   				= Input::get('site');
	        $model->city_departure   	= empty($city_departure)?0:1;
	        $model->country_departure   = empty($country_departure)?0:1;

	        if(Input::hasFile('userfile')) {
				$image = Common_helper::fileUpload(Input::file('userfile'),'images/'.Auth::user()->alias,'avatar');
				if(isset($image['path']) && !empty($image['path'])){
					$thumbPath = 'uploads/images/'.Auth::user()->alias.'/thumb_'.$image['name'];
					Common_helper::getThumb(base_path().'/public/'.$image['path'],base_path().'/public/'.$thumbPath,100,100);
					$model->avatar = $thumbPath;
				}
			}
			if(Input::hasFile('usercard')) {
				$image = Common_helper::fileUpload(Input::file('usercard'),'images/'.Auth::user()->alias,'usercard_cover');
				if(isset($image['path']) && !empty($image['path'])){
					$thumbPath = 'uploads/images/'.Auth::user()->alias.'/thumb_'.$image['name'];
					Common_helper::getThumb(base_path().'/public/'.$image['path'],base_path().'/public/'.$thumbPath,260,315,false);
					$model->usercard_cover = $thumbPath;
				}
			}
        	$model->save();
		}
		$view = View::make('content.front.messagebox',array('message'=>'Информация о пользователе добавлена!'))->render();
        return Redirect::back()->with('message', $view);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function putUpdate($id)
	{
		$role = Userinfo::find($id);
		if(empty($role)){
			App::abort(404);
		}
		
		$validator = Validator::make($data = Input::all(), $this->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			header('Content-Type: text/html; charset=utf-8');
			$city_departure = Input::get('city_departure');
			$country_departure = Input::get('country_departure');

			$data = array(
		        'name'   			=> Input::get('name'),
		        'surname'   		=> Input::get('surname'),
		        'city'   			=> Input::get('city'),
		        'birthday'   		=> $this->getTime(Input::get('birthday')),
		        'gender'   			=> Input::get('gender'),
		        'phone'   			=> Input::get('phone'),
		        'biography'   		=> Input::get('biography'),
		        'additional_email'  => Input::get('additional_email'),
		        'site'   			=> Input::get('site'),
		        'city_departure'   	=> empty($city_departure)?0:1,
		        'country_departure' => empty($country_departure)?0:1,	        
	        );

	        if(Input::hasFile('userfile')) {
				$image = Common_helper::fileUpload(Input::file('userfile'),'images/'.Auth::user()->alias,'avatar');
				if(isset($image['path']) && !empty($image['path'])){
					$thumbPath = 'uploads/images/'.Auth::user()->alias.'/thumb_'.$image['name'];
					Common_helper::getThumb(base_path().'/public/'.$image['path'],base_path().'/public/'.$thumbPath,100,100);
					$data['avatar'] = $thumbPath;
				}
			} else {
				$imageexist = Input::get('imageexist');
				if(empty($imageexist)){
					$data['avatar'] = '';
				}
			}

			if(Input::hasFile('usercard')) {
				$image = Common_helper::fileUpload(Input::file('usercard'),'images/'.Auth::user()->alias,'usercard_cover');
				if(isset($image['path']) && !empty($image['path'])){
					$thumbPath = 'uploads/images/'.Auth::user()->alias.'/thumb_'.$image['name'];
					Common_helper::getThumb(base_path().'/public/'.$image['path'],base_path().'/public/'.$thumbPath,260,315,false);
					$data['usercard_cover'] = $thumbPath;
				}
			}        

        	$role->update($data);
		}
		$view = View::make('content.front.messagebox',array('message'=>'Информация о пользователе обновлена!'))->render();
        return Redirect::back()->with('message', $view);
	}

	private function getTime($date){
		if(empty($date)){
			return 0;
		}
		$monthes = array(
		    'Января' 	=> 'January',
		    'Февраля' 	=> 'February', 
		    'Марта' 	=> 'March', 
		    'Апреля' 	=> 'April',
		    'Мая' 		=> 'May', 
		    'Июня' 		=> 'June', 
		    'Июля' 		=> 'July', 
		    'Августа' 	=> 'August',
		    'Сентября' 	=> 'September', 
		    'Октября' 	=> 'October', 
		    'Ноября' 	=> 'November', 
		    'Дукабря' 	=> 'December'
		);
		$dateArray = explode(' ',$date);
		if(!isset($dateArray[1])){
			return 0;
		}
		$dateArray[1] = $monthes[$dateArray[1]];
		$date = implode(' ',$dateArray);
		$time = strtotime($date);
		return $time;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteDestroy($id)
	{
		Userinfo::destroy($id);
		Session::flash('success', 'Удалено!');
		return Redirect::to('admin/users');
	}

}