<?php

class ArticleController extends BaseController {

	protected $rules = array(
		'title'		=> 'required',
		'alias'		=> 'max:128|unique:articles,alias'
	);
	protected $table_fields = array(
			'Название'	=> 'title',
			'Автор'		=> 'users.username',
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
		$model = new Article;
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);
		$table_fields = $this->table_fields;

        $articles = $model->getArticles($table_fields,$params);

		return View::make('content.admin.articles.index', compact('articles','table_fields'));
	}

	/**
	 * Show the form for creating a new resource
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('content.admin.articles.form');
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
			return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
		} else {
			$image = '';
			$thumb = '';
			$uploadedImage = Input::file('userfile');
			if(!empty($uploadedImage)){
				$image = Common_helper::fileUpload($uploadedImage,'images/'.Auth::user()->alias);
				$thumb = 'uploads/images/'.Auth::user()->alias.'/thumb_'.$image['name'];
	        	Common_helper::getThumb($image['path'],$thumb,260,260);
	        	$image = $image['path'];
			}

			$model = new Article;
 
	        $model->title   	= Input::get('title');
	        $model->alias   	= Input::get('alias');
	        $model->content   	= Input::get('content');
	        $model->onfront   	= Input::get('onfront')?Input::get('onfront'):0;
	        $model->user_id   	= Auth::User()->id;
	        $model->image 		= $image;
	        $model->thumb 		= $thumb;

        	$model->save();
		}

		Session::flash('success', 'Статья создана!');
		return Redirect::back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($id)
	{
		$article = article::find($id);

		if(!empty($article)){	
			return View::make('articles::admin.form', compact('article'));
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
		$article = Article::find($id);
		if(!empty($article)){
			return View::make('content.admin.articles.form', compact('article'));
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
		$article = Article::find($id);
		if(empty($article)){
			App::abort(404);
		}
		
		$this->rules['alias'] = '';
		$this->rules['alias'] = 'max:128|unique:articles,alias,'.$id;
		$validator = Validator::make($data = Input::all(), $this->rules);

		if ($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$image = $article->image;
		$thumb = $article->thumb;
		$uploadedImage = Input::file('userfile');
		if(!empty($uploadedImage)){
			$image = Common_helper::fileUpload($uploadedImage,'images/'.Auth::user()->alias);
			$thumb = 'uploads/images/'.Auth::user()->alias.'/thumb_'.$image['name'];
        	Common_helper::getThumb($image['path'],$thumb,260,260);
        	$image = $image['path'];
		}
		$existImage = Input::get('image');
		if(empty($existImage) && empty($uploadedImage)){
			$image = '';
			$thumb = '';
		}

		$data = array(
	        'title'  	 => Input::get('title'),
	        'alias'      => Input::get('alias'),		        
	        'content' 	 => Input::get('content'),
	        'onfront' 	 => Input::get('onfront'),
	        'image'		 => $image,
	        'thumb'		 => $thumb,
        );	        

    	$article->update($data);

		Session::flash('success', 'Данные статьи обновлены!');
		return Redirect::back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteDestroy($id)
	{
		Article::destroy($id);
		Session::flash('success', 'Статья удалена!');
		return Redirect::to('admin/articles');
	}

}