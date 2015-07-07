<?php

class BlogsubcategoriesController extends BaseController {

	protected $rules = array(
		'name'		=> 'required|max:128',
	);
	protected $table_fields = array(
		'Имя'			=> 'blog_subcategories.name',
		'Категория'		=> 'blog_categories.name',
		'Создана'		=> 'blog_subcategories.created_at',
		'Обноввлена'	=> 'blog_subcategories.updated_at',
	);	


/**
* Display a listing of resources
*
* @return Response
*/
	public function getIndex()
	{
		$model = new Blogsubcategory;
		$table_fields = $this->table_fields;
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);
		$subcategories = $model->getBlogSubCategories($table_fields,$params);
		return View::make('content.admin.blogsubcategories.index',compact('table_fields','subcategories'));
	}

/**
 * Show the form for creating a new resource
 *
 * @return Response
 */
	public function getCreate()
	{
		$categories = Blogcategory::lists('name','id');
		return View::make('content.admin.blogsubcategories.form',compact('categories'));
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
			$model = new Blogsubcategory;
			$model->name   		= Input::get('name');
	        $model->category_id = Input::get('category_id');

        	$model->save();
		}

		Session::flash('success', 'Категория блога добавлена!');
		return Redirect::to('/admin/blog/subcategories');
	}

/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return Response
 */
	public function getEdit($id)
	{
		$subcategory = Blogsubcategory::find($id);
		$categories = Blogcategory::lists('name','id');
		if(!empty($subcategory)){
			return View::make('content.admin.blogsubcategories.form', compact('subcategory','categories'));
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
		$subcategory = Blogsubcategory::find($id);
		if(empty($subcategory)){
			App::abort(404);
		}
		
		$validator = Validator::make($data = Input::all(), $this->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$data = array(
		        'name'      		=> Input::get('name'),
		        'category_id' 		=> Input::get('category_id'),        
	        );	        

        	$subcategory->update($data);
		}
		Session::flash('success', 'Данные обновлены!');

		return Redirect::to('admin/blog/subcategories');
	}

/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return Response
 */
	public function deleteDestroy($id)
	{
		Blogsubcategory::destroy($id);
		Session::flash('success', 'Удалено!');
		return Redirect::to('admin/blog/subcategories');
	}
}