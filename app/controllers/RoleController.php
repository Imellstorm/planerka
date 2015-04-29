<?php

class RoleController extends BaseController {

	protected $rules = array(
		'name'		=> 'required|max:256'
	);
	protected $table_fields = array(
			'Наименование'	=> 'name',
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
		$model = new Role;
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);
		$table_fields = $this->table_fields;

        $roles = $model->getRoles($table_fields,$params);

		return View::make('content.admin.roles.index', compact('roles','table_fields'));
	}

	/**
	 * Show the form for creating a new resource
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('content.admin.roles.form');
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
			$model = new Role;

	        $model->name   	= Input::get('name');

        	$model->save();
		}

		Session::flash('success', 'Тип пользователя добавлен!');
		if(Auth::check() && Auth::User()->role->id == 1){
			return Redirect::to('/admin/roles');
		} else{
			return Redirect::to('/');
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$role = Role::find($id);
		if(!empty($role)){
			return View::make('content.admin.roles.form', compact('role'));
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
		$role = Role::find($id);
		if(empty($role)){
			App::abort(404);
		}
		
		$validator = Validator::make($data = Input::all(), $this->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$data = array(
		        'name'      => Input::get('name'),	        
	        );	        

        	$role->update($data);
		}
		Session::flash('success', 'Данные обновлены!');

		return Redirect::to('admin/roles');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteDestroy($id)
	{
		Role::destroy($id);
		Session::flash('success', 'Удалено!');
		return Redirect::to('admin/roles');
	}

}