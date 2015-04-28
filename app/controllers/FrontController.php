
<?php

class FrontController extends BaseController {

	public function getIndex(){
		if(Input::get('search')){
			return View::make('content.front.search');
		}
		return View::make('content.front.index');
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
