
<?php

class FrontController extends BaseController {

	public function __construct(){

    }


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

	public function getPost($id)
	{
		$course = $this->retriveCourse();
		$selectedCurrency = strtoupper(Cookie::get('cur'));
		if(empty($selectedCurrency)) $selectedCurrency = 'UAH';

		$postModel = new Post;
		$commentModel = new Comment;
		$licenseModel = new License;
		$post = $postModel->getpost($id);
		if(!empty($post)){	
			$licenses = $licenseModel->wherein('id',explode(',',$post->licenses))->get();
			$comments = $commentModel->getPostComments($id);
			return View::make('content.front.posts.singl', compact('post','comments','licenses','course','selectedCurrency'));
		} else {
			App::abort(404);
		}
	}

	public function getOnenews($id){
		$model = new Article;
		$page = $model->find($id);
		if(!empty($page)){	
			return View::make('content.front.news.singl', compact('page'));
		} else {
			App::abort(404);
		}
	}

	public function changeLanguage($lang){		
		$cookie = Cookie::forever('lang', $lang);
		return Redirect::back()->withCookie($cookie);;
	}

	public function changeCurrency($cur){		
		$cookie = Cookie::forever('cur', $cur);
		return Redirect::back()->withCookie($cookie);;
	}
}
