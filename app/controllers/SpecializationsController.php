<?php

class SpecializationsController extends BaseController {

	protected $rules = array(
		'role'	=> 'required',
	);

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{	
		$roles = Input::get('role');
		$prices = Input::get('price');
		$descriptions = Input::get('description');

		if(!is_array($roles)){
			return Redirect::back()->withErrors(array('role'=>'Ошибка специализаций'));
		}

		foreach ($roles as $key => $role){
			$validator = Validator::make(Input::all(), $this->rules);
			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator);
			} elseif($role!=2) {
				$model = new Specialization;
				$model->user_id		= Auth::user()->id;
				$model->role_id 	= $role;
				$model->price 		= $prices[$key];
				$model->description = $descriptions[$key];
				$model->save();

				if($key==0 && $role!=1){
					$model = new User;
					$model->find(Auth::user()->id);
					$model->update(array('role_id'=>$role));
				}
			}
		}
		$view = View::make('content.front.messagebox',array('message'=>'Специализации сохранены!'))->render();
        return Redirect::back()->with('message', $view);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function putUpdate()
	{
		Specialization::where('user_id',Auth::user()->id)->delete();
		$this->postStore();
		$view = View::make('content.front.messagebox',array('message'=>'Специализации обновлены!'))->render();
        return Redirect::back()->with('message', $view);
	}
}