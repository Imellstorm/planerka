<?php

class OwnershipController extends BaseController {

	protected $rules = array(
		'abr'		=> 'required|max:128',
		'name'		=> 'required|max:256',
		//'abr_ukr'	=> 'required|max:128',
		//'name_ukr'	=> 'required|max:256',
	);
	protected $table_fields = array(
			'Сокращенно'	=> 'abr',
			'Наименование'	=> 'name',
			'Создано'		=> 'created_at',
			'Обновлено'		=> 'updated_at',
		);	

	/**
	* Display a listing of resources
	*
	* @return Response
	*/
	public function getIndex()
	{
		$model = new Ownership;
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);
		$table_fields = $this->table_fields;

        $ownership = $model->getOwnerships($table_fields,$params);

		return View::make('content.admin.ownership.index', compact('ownership','table_fields'));
	}

	/**
	 * Show the form for creating a new resource
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('content.admin.ownership.form');
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
			$model = new Ownership;
 
	        $model->abr   		= Input::get('abr');
	        $model->name   		= Input::get('name');
	        $model->abr_ukr   	= Input::get('abr_ukr');
	        $model->name_ukr   	= Input::get('name_ukr');

        	$model->save();
		}

		Session::flash('success', 'Форма создана!');
		if(Auth::check() && Auth::User()->role->id == 1){
			return Redirect::to('/admin/ownerships');
		} else{
			return Redirect::to('/');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($id)
	{
		$ownership = Ownership::find($id);

		if(!empty($ownership)){	
			return View::make('ownership::admin.form', compact('ownership'));
		} else {
			App::abort(404);
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
		$ownership = Ownership::find($id);
		if(!empty($ownership)){
			return View::make('content.admin.ownership.form', compact('ownership'));
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
		$ownership = Ownership::find($id);
		if(empty($ownership)){
			App::abort(404);
		}
		
		$validator = Validator::make($data = Input::all(), $this->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$data = array(
		        'abr'  	 	=> Input::get('abr'),
		        'name'      => Input::get('name'),	
		        'abr_ukr'  	=> Input::get('abr_ukr'),
		        'name_ukr'  => Input::get('name_ukr'),	        
	        );	        

        	$ownership->update($data);
		}
		Session::flash('success', 'Данные обновлены!');

		return Redirect::to('admin/ownerships');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteDestroy($id)
	{
		Ownership::destroy($id);
		Session::flash('success', 'Удалено!');
		return Redirect::to('admin/ownerships');
	}

}