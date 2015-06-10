
<?php

class FrontController extends BaseController {

	public function getIndex(){
		if(Input::get('search')){
			return View::make('content.front.search');
		}
		$vote = Vote::where('active',1)->first();
		if(!empty($vote)){
			if(Auth::check()){
				$userVoted = Votedusers::where('user_id',Auth::user()->id)->where('vote_id',$vote->id)->first();
			} else {
				$userVoted = false;
			}
			$answers = Voteanswer::where('vote_id',$vote->id)->get();
		}
		return View::make('content.front.index',compact('vote','answers','userVoted'));
	}

	public function page($alias){
		$model = new Article;
		$page  = $model->where('alias',$alias)->first();
		if(empty($page)){
			App::abort(404);
		}
		return View::make('content.front.page',compact('page'));
	}
}
