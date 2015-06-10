<?php

class VoteController extends BaseController {

	protected $table_fields = array(
			'Вопрос'			=> 'question',
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
		$model = new Vote;
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);
		$table_fields = $this->table_fields;

        $votes = $model->getVotes($table_fields,$params);

		return View::make('content.admin.votes.index', compact('votes','table_fields'));
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
	public function postStore()
	{
		$rules = array('question' => 'required');
		$validator = Validator::make(Input::all(),$rules);

		if ($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$model = new Vote;
	        $model->question = Input::get('question');
        	$model->save();
		}

		$answers = Input::get('answers');
		if(count($answers)){
			foreach ($answers as $key => $val) {
				$answersdata[] = array('text'=>$val,'vote_id'=>$model->id);
			}
			$answermodel = new Voteanswer;
			$answermodel->insert($answersdata);
		}

		Session::flash('success', 'Опрос создан!');
		return Redirect::to('/admin/vote');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$vote = Vote::find($id);
		if(!empty($vote)){
			$answers = Voteanswer::where('vote_id',$id)->get();
			return View::make('content.admin.votes.form', compact('vote','answers'));
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
		$vote = Vote::find($id);
		if(empty($vote)){
			App::abort(404);
		}
		
		$rules = array('question' => 'required');
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$data = array(
		        'question'  => Input::get('question'),
	        );	        
        	$vote->update($data);

        	$answers = Input::get('answers');
        	$answermodel = new Voteanswer;
        	$answermodel->where('vote_id',$id)->delete();
			if(count($answers)){
				foreach ($answers as $key => $val) {
					$answersdata[] = array('text'=>$val,'vote_id'=>$id);
				}
				$answermodel->insert($answersdata);
			}
		}
		Session::flash('success', 'Данные опроса обновлены!');
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
		Vote::destroy($id);
		Session::flash('success', 'Опрос удален!');
		return Redirect::to('admin/vote');
	}

	public function postProccess(){
		$answerId = Input::get('answer');
		$answer = Voteanswer::find($answerId);
		if(empty($answer)){
			App::abort(404);
		}
		$votedUser = Votedusers::where('user_id',Auth::user()->id)->where('vote_id',$answer->vote_id)->first();
		if(empty($votedUser)){
			$answer->update(array('click_count'=>$answer->click_count+1));
			$model = new Votedusers;
			$model->user_id = Auth::user()->id;
			$model->vote_id = $answer->vote_id;
			$model->save;
		} else {
			return Redirect::back()->withErrors(array('Вы уже голосовали'));
		}
		return Redirect::back();
	}

	public function getActivate($id=''){
		$vote = Vote::find($id);
		if(!Auth::check() || Auth::user()->role_id!=1 || empty($vote)){
			App:abort(404);
		}

		$model = new Vote;
		$model->update(array('active'=>0));
		$vote->update(array('active'=>1));
		return Redirect::back();
	}
}