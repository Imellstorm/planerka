<?php

class ProfileController extends BaseController {

	public function __construct(){
		parent::__construct();
		$alias = Route::current()->getParameter('useralias');
		$this->user = User::where('alias',$alias)->first();
		if(empty($this->user)){
			App::abort(404);
		}
		$this->getUserinfo($this->user->id);
		View::share('profile',true);
		View::share('user',$this->user);
    }

	/**
	 * Show Profile photo page
	 *
	 * @return Response
	 */
	public function getIndex(){
		$mainProf = Specialization::join('roles','roles.id','=','specializations.role_id')->where('role_id',$this->user->role_id)->where('user_id',$this->user->id)->first();
		$otherProf = Specialization::join('roles','roles.id','=','specializations.role_id')->where('user_id',$this->user->id)->where('role_id','!=',$this->user->role_id)->get();
		$userinfo = Userinfo::where('user_id',$this->user->id)->first();
		$user = $this->user;

		$albums = Album::select('albums.*',DB::raw('count('.DB::getTablePrefix().'images.id) as imgcount'))->leftjoin('images','images.album_id','=','albums.id')->where('albums.user_id',$this->user->id)->groupby('albums.id')->get();
		if(!empty($albums)){
			foreach ($albums as $key => $val) {
				$albums[$key]->images = Image::where('album_id',$val->id)->get();
			}
		}

		if(!empty($userinfo)){
			//echo '<fix style="display:none"></fix>'; // фикс странного бага с удвоением инкримента
			$userinfo->increment('enters_count');
		}
		return View::make('content.front.profile.photo',compact('mainProf','otherProf','user','userinfo','registerdTime','albums'));
	}

	/**
	 * Show Profile video page
	 *
	 * @return Response
	 */
	public function getVideo(){
		$video = Video::where('user_id',$this->user->id)->get();
		return View::make('content.front.profile.video',compact('video'));
	}

	/**
	 * Show Profile Reviews page
	 *
	 * @return Response
	 */
	public function getReviews(){
		$reviews = Review::select('users.alias','projects.title as project_title','user_info.*','reviews.*')
		->leftjoin('projects','projects.id','=','reviews.project_id')
		->leftjoin('user_info','user_info.user_id','=','reviews.from_user')
		->leftjoin('users','users.id','=','reviews.from_user')
		->where('to_user',$this->user->id)->get();
		return View::make('content.front.profile.reviews',compact('reviews'));
	}

	/**
	 * Show Profile calendar page
	 *
	 * @return Response
	 */
	public function getCalendar(){
		if(!Auth::check() && Auth::user()->role_id!=2){
			App::abort(404);
		}
		$dates = Calendar::where('user_id',Auth::user()->id)->get();
		return View::make('content.front.profile.calendar',compact('dates'));
	}	
}