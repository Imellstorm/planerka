<?php

class BlogcategoriesController extends BaseController {

	protected $rules = array(
		'name'		=> 'required|max:128',
	);
	protected $table_fields = array(
		'Имя'			=> 'name',
		'Создана'		=> 'created_at',
		'Обноввлена'	=> 'updated_at',
	);	


/**
* Display a listing of resources
*
* @return Response
*/
	public function getIndex()
	{
		$model = new Blogcategory;
		$table_fields = $this->table_fields;
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);
		$categories = $model->getBlogCategories($table_fields,$params);
		return View::make('content.admin.blogcategories.index',compact('table_fields','categories'));
	}

/**
 * Show the form for creating a new resource
 *
 * @return Response
 */
	public function getCreate()
	{
		return View::make('content.admin.blogcategories.form');
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
			$model = new Blogcategory;

	        $model->name   			= Input::get('name');

        	$model->save();
		}

		Session::flash('success', 'Категория блога добавлена!');
		return Redirect::to('/admin/blog/categories');
	}

/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return Response
 */
	public function getEdit($id)
	{
		$category = Blogcategory::find($id);
		if(!empty($category)){
			return View::make('content.admin.blogcategories.form', compact('category'));
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
		$category = Blogcategory::find($id);
		if(empty($category)){
			App::abort(404);
		}
		
		$validator = Validator::make($data = Input::all(), $this->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$data = array(
		        'name'      		=> Input::get('name'),	        
	        );	        

        	$category->update($data);
		}
		Session::flash('success', 'Данные обновлены!');

		return Redirect::to('admin/blog/categories');
	}

/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return Response
 */
	public function deleteDestroy($id)
	{
		Blogcategory::destroy($id);
		Session::flash('success', 'Удалено!');
		return Redirect::to('admin/blog/categories');
	}

}