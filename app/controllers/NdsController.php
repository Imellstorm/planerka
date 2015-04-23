<?php

class NdsController extends BaseController {

	protected $rules = array(
		'abr'		=> 'required|max:128',
		'name'		=> 'required|max:256'
	);
	protected $table_fields = array(
			'Сокращенно'	=> 'abr',
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
		$model = new Nds;
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);
		$table_fields = $this->table_fields;

        $nds = $model->getNds($table_fields,$params);

		return View::make('content.admin.nds.index', compact('nds','table_fields'));
	}

	/**
	 * Show the form for creating a new resource
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('content.admin.nds.form');
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
			$model = new Nds;
 
	        $model->abr   	= Input::get('abr');
	        $model->name   	= Input::get('name');

        	$model->save();
		}

		Session::flash('success', 'Форма создана!');
		if(Auth::check() && Auth::User()->role->id == 1){
			return Redirect::to('/admin/nds');
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
		$nds = nds::find($id);

		if(!empty($nds)){	
			return View::make('nds::admin.form', compact('nds'));
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
		$nds = Nds::find($id);
		if(!empty($nds)){
			return View::make('content.admin.nds.form', compact('nds'));
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
		$nds = Nds::find($id);
		if(empty($nds)){
			App::abort(404);
		}
		
		$validator = Validator::make($data = Input::all(), $this->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$data = array(
		        'abr'  	 	=> Input::get('abr'),
		        'abr_ukr'  	=> Input::get('abr_ukr'),
		        'name'      => Input::get('name'),
		        'name_ukr'  => Input::get('name_ukr'),		        
	        );	        

        	$nds->update($data);
		}
		Session::flash('success', 'Данные обновлены!');

		return Redirect::to('admin/nds');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteDestroy($id)
	{
		Nds::destroy($id);
		Session::flash('success', 'Удалено!');
		return Redirect::to('admin/nds');
	}

}