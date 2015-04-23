<?php

class UserstatusController extends BaseController {

	protected $rules = array(
		'icon'		=> 'max:128',
		'name'		=> 'max:128'
	);
	protected $table_fields = array(
			'Иконка'	=> 'icon',
			'Название'	=> 'name',
			'Создано'	=> 'created_at',
			'Обновлено'	=> 'updated_at',
		);	

	/**
	* Display a listing of resources
	*
	* @return Response
	*/
	public function getIndex()
	{
		$model = new Userstatus;
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);
		$table_fields = $this->table_fields;

        $userstatus = $model->getUserstatus($table_fields,$params);

		return View::make('content.admin.userstatus.index', compact('userstatus','table_fields'));
	}

	/**
	 * Show the form for creating a new resource
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('content.admin.userstatus.form');
	}


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
			return Redirect::back()->withErrors($validator);
		} else {
			$model = new Userstatus;
 
	        $model->icon   		= Input::get('icon');
	        $model->name   		= Input::get('name');
	        $model->description = Input::get('description');	        

        	$model->save();
		}

		Session::flash('success', 'Статус пользователя создан!');

		return Redirect::to('/admin/user_status');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($id)
	{
		App::abort(404);	
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$userstatus = Userstatus::find($id);
		if(!empty($userstatus)){
			return View::make('content.admin.userstatus.form', compact('userstatus'));
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
		$userstatus = Userstatus::find($id);
		if(empty($userstatus)){
			App::abort(404);
		}
		
		$validator = Validator::make($data = Input::all(), $this->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$data = array(
		        'icon'  		=> Input::get('icon'),
		        'name'      	=> Input::get('name'),
		        'description'	=> Input::get('description'),		        
	        );	        

        	$userstatus->update($data);
		}
		Session::flash('success', 'Данные обновлены!');

		return Redirect::to('admin/user_status');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteDestroy($id)
	{
		Userstatus::destroy($id);
		Session::flash('success', 'Удалено!');
		return Redirect::to('admin/user_status');
	}

}