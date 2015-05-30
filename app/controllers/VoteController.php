<?php

class VoteController extends BaseController {

	protected $table_fields = array(
			'Ответ'				=> 'text',
			'Проголосовало'		=> 'click_count',
			'Создано'			=> 'created_at',
			'Обновлено'			=> 'updated_at',
		);	

	/**
	* Display a listing of resources
	*
	* @return Response
	*/
	public function getIndex()
	{
		$model = new Voteanswer;
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);
		$table_fields = $this->table_fields;

		$vote = Vote::first();
        $answers = $model->getAnswers($table_fields,$params);

		return View::make('content.admin.votes.index', compact('answers','vote','table_fields'));
	}

	/**
	 * Show the form for creating a new resource
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('content.admin.votes.form');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStorequestion()
	{
		$rules = array('question' => 'required');
		$validator = Validator::make(Input::all(),$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$model = new Vote;
	        $model->question = Input::get('question');
        	$model->save();
		}

		Session::flash('success', 'Опрос создан!');
		return Redirect::to('/admin/vote');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{
		$rules = array('text' => 'required');
		$validator = Validator::make(Input::all(),$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$model = new Voteanswer;
	        $model->text   	= Input::get('text');
        	$model->save();
		}

		Session::flash('success', 'Ответ создан!');
		return Redirect::to('/admin/vote');
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
		$answer = Voteanswer::find($id);
		if(!empty($answer)){
			return View::make('content.admin.votes.form', compact('answer'));
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
	public function putUpdatequestion($id)
	{
		$vote = Vote::find($id);
		if(empty($vote)){
			App::abort(404);
		}
		
		$rules = array('question' => 'required');
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$data = array(
		        'question'  => Input::get('question'),
	        );	        

        	$vote->update($data);
		}
		Session::flash('success', 'Данные опроса обновлены!');

		return Redirect::to('admin/vote');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function putUpdate($id)
	{
		$answer = Voteanswer::find($id);
		if(empty($answer)){
			App::abort(404);
		}
		
		$rules = array('text' => 'required');
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$data = array(
		        'text'  => Input::get('text'),
	        );	        

        	$answer->update($data);
		}
		Session::flash('success', 'Данные ответа обновлены!');

		return Redirect::to('admin/vote');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteDestroy($id)
	{
		Voteanswer::destroy($id);
		Session::flash('success', 'Ответ удален!');
		return Redirect::to('admin/vote');
	}

	public function postProccess(){
		$answerId = Input::get('answer');
		$user = User::find(Auth::user()->id);

		if(empty($user->voted)){
			$answer = Voteanswer::find($answerId);
			if(empty($answer)){
				App::abort(404);
			}
			$answer->update(array('click_count'=>$answer->click_count+1));
			$user->update(array('voted'=>1));
		} else {
			return Redirect::back()->withErrors(array('Вы уже голосовали'));
		}
		return Redirect::back();
	}
}