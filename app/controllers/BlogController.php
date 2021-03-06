<?php

class BlogController extends BaseController {

	public function __construct(){
		parent::__construct();
	}

	public function getIndex(){
		$categories = Blogsubcategory::select('blog_categories.name as parent_name','blog_subcategories.*')
			->leftjoin('blog_categories','blog_categories.id','=','blog_subcategories.category_id')
			->groupBy('blog_subcategories.id')
			->orderBy('category_id')
			->get();
		if(count($categories)){
			foreach ($categories as $key => $val) {
				$categories[$key]->themes_count = Blogtheme::where('subcategory',$val->id)->count();
				$categories[$key]->posts_count = Blogpost::leftjoin('blog_themes','blog_themes.id','=','blog_posts.theme_id')
														 ->leftjoin('blog_subcategories','blog_subcategories.id','=','blog_themes.subcategory')
														 ->where('blog_themes.subcategory',$val->id)
														 ->count();
			}
		}
		return View::make('content.front.blog.index',compact('categories'));
	}

	public function getLastblogthemes($interval=''){
		$result = Blogtheme::select(DB::raw('COUNT('.DB::getTablePrefix().'blog_posts.id) as postscount'),'blog_themes.*')
			->leftjoin('blog_posts','blog_posts.theme_id','=','blog_themes.id')
			->groupBy('blog_themes.id')
			->orderBy('postscount','DESC')
			->take(4);
		if(!empty($interval)){
			$date = new DateTime;
			$date->modify('-1 '.$interval);
			$result->where('blog_themes.created_at', '>', $date->format('Y-m-d'));
		}
		$blogThemes = $result->get();
		if(Request::ajax()){
			return View::make('content.front.blog.themeslist',compact('blogThemes')); 
		}
		return $blogThemes;
	}

	public function getCategory($id){
		$subcategory = Blogsubcategory::where('id',$id)->first();
		if(empty($subcategory)){
			App::abort(404);
		}
		$category = Blogcategory::where('id',$subcategory->category_id)->first();
		if(empty($category)){
			App::abort(404);
		}
		$themes = Blogtheme::select('blog_posts.text','user_info.*','users.online','users.alias','user_info.name as user_name','blog_themes.*')
				->leftjoin('blog_posts','blog_posts.theme_id','=','blog_themes.id')
				->leftjoin('user_info','user_info.user_id','=','blog_themes.user_id')
				->leftjoin('users','users.id','=','blog_themes.user_id')
				->where('subcategory',$id)
				->groupBy('blog_themes.id')
				->paginate(10);
		foreach ($themes as $key => $val) {
			$themes[$key]->posts_count = Blogpost::where('theme_id',$val->id)->count();
		}
		return View::make('content.front.blog.category',compact('category','subcategory','themes'));
	}

	public function getTheme($id){
		$theme = Blogtheme::where('id',$id)->first();
		if(empty($theme)){
			App::abort(404);
		}
		$subcategory = Blogsubcategory::where('id',$theme->subcategory)->first();
		if(empty($subcategory)){
			App::abort(404);
		}
		$category = Blogcategory::where('id',$subcategory->category_id)->first();
		if(empty($category)){
			App::abort(404);
		}
		$posts = Blogpost::select('user_info.*','users.online','users.alias','user_info.name as user_name','blog_posts.*')
			->leftjoin('user_info','user_info.user_id','=','blog_posts.user_id')
			->leftjoin('users','users.id','=','blog_posts.user_id')
			->where('theme_id',$id)
			->orderBy('blog_posts.id')
			->paginate(10);
		foreach ($posts as $key => $val) {
			$val->images = Blogimage::where('post_id',$val->id)->get();
		}
		return View::make('content.front.blog.theme',compact('category','subcategory','theme','posts'));
	}

	public function getCreatetheme($category_id=''){
		$category = Blogsubcategory::where('id',$category_id)->first();
		if(empty($category)){
			App::abort(404);
		}
		return View::make('content.front.blog.createtheme',compact('category_id'));
	}

	public function getDeletetheme($id=''){
		$theme = Blogtheme::where('id',$id)->first();
		if(!Auth::check() || empty($theme) || (Auth::user()->id!=$theme->user_id && Auth::user()->role_id!=1)){
			App::abort(404);
		}
		Blogpost::where('theme_id',$id)->delete();
		Blogtheme::destroy($id);
		return Redirect::back();
	}

	public function getDeletepost($id=''){
		$post = Blogpost::where('id',$id)->first();
		if(!Auth::check() || empty($post) || (Auth::user()->id!=$post->user_id && Auth::user()->role_id!=1)){
			App::abort(404);
		}
		Blogimage::where('post_id',$id)->delete();
		Blogpost::destroy($id);
		return Redirect::back();
	}

	public function getMyposts(){
		$themes = Blogtheme::select('blog_posts.text','user_info.*','users.online','user_info.name as user_name','blog_themes.*')
				->leftjoin('blog_posts','blog_posts.theme_id','=','blog_themes.id')
				->leftjoin('user_info','user_info.user_id','=','blog_themes.user_id')
				->leftjoin('users','users.id','=','blog_themes.user_id')
				->where('blog_posts.user_id',Auth::user()->id)
				->groupBy('blog_themes.id')
				->paginate(10);
		return View::make('content.front.blog.myposts',compact('themes'));
	}

	public function postSavepost(){
		if (!Request::ajax()){
			return '';
		}
		if(!Auth::check()){
			return '';
		}
		$theme = Blogtheme::where('id',Input::get('theme_id'))->first();
		if(empty($theme)){
			return '';
		}

		$post = new Blogpost;
		$post->user_id 	= Auth::user()->id;
		$post->text 	= Input::get('text');
		$post->theme_id = Input::get('theme_id');
		$post->save();

		if($post->user_id != $theme->user_id){
			$notify = new Notifications;
			$notify->from_user = Auth::user()->id;
			$notify->to_user = $theme->user_id;
			$notify->text = 'У вас новое сообщение в блоге';
			$notify->link = 'blog/theme/'.$theme->id;
			$notify->save();
		}

		$this->saveRating();

		return $post->id;
	}

/**
 * Store a newly created resource in storage.
 *
 * @return Response
 */
	public function postStoretheme()
	{
		if(!Auth::check()){
			App::abort(404);
		}
		$subcategory_id = Input::get('subcategory_id');
		$subcategory = Blogsubcategory::where('id',$subcategory_id)->first();
		if(empty($subcategory)){
			App::abort(404);
		}

		$rules = array(
			'theme_name' 		=> 'required|max:256',
			'subcategory_id'	=> 'required',
			'text'				=> 'required',
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator);
		} else {
			$theme = new Blogtheme;
	        $theme->name   		= Input::get('theme_name');
	        $theme->user_id		= Auth::user()->id;
	        $theme->subcategory	= Input::get('subcategory_id');
        	$theme->save();

        	$post = new Blogpost;
        	$post->user_id 	= Auth::user()->id;
        	$post->theme_id = $theme->id;
        	$post->text 	= Input::get('text');
        	$post->save();
		}

		$this->saveRating();

		$view = View::make('content.front.messagebox',array('message'=>'Тема блога добавлена!'))->render();
		return Redirect::back()->with('message', $view);
	}

	private function saveRating(){
		$model = new Ratinghistory;

		$startToday = date('Y-m-d 00:00:00');
		$endToday = date('Y-m-d 23:59:59');
		$todayRatingCount = $model->where('user_id', Auth::user()->id)
			->where('type','blogactivity')
			->whereBetween('created_at', array($startToday,$endToday))
			->count();
		
		if($todayRatingCount < 1){
			$model->user_id = Auth::user()->id;
			$model->user_type = Auth::user()->role_id==2?'customer':'performer';
			$model->amount = 1;
			$model->type = 'blogactivity';
			$model->save();

			$userInfo = Userinfo::where('user_id',Auth::user()->id)->first();
			$newRating = $userInfo->rating+1;
			$userInfo->update(array('rating'=>$newRating));
		}
	}
}