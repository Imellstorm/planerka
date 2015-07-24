<?php

class ProfileController extends BaseController {

	public function __construct(){
		parent::__construct();
		$alias = Route::current()->getParameter('useralias');
		$this->user = User::where('alias',$alias)->first();
		if(empty($this->user)){
			App::abort(404);
		}
		$projectsDone = Userstoproject::where('user_id',$this->user->id)->where('status',6)->get();
		$this->getUserinfo($this->user->id);
		$favoriteExist = $this->getFavorites();

		View::share('favoriteExist',$favoriteExist);
		View::share('profile',true);
		View::share('user',$this->user);
		View::share('projectsDoneCount',count($projectsDone));
    }

    private function getFavorites(){
    	if(Auth::check()){
			$favoriteExist = Favorites::where('selected_user_id',$this->user->id)->where('user_id',Auth::user()->id)->first();
			if(!empty($favoriteExist)){
				$favoriteExistVal=$favoriteExist->id;
			} else {
				$favoriteExistVal=false;
			}	
			return $favoriteExistVal;
		}
    }

	/**
	 * Show Profile photo page
	 *
	 * @return Response
	 */
	public function getIndex(){
		$mainProf = Specialization::join('roles','roles.id','=','specializations.role_id')->where('role_id',$this->user->role_id)->where('user_id',$this->user->id)->first();
		if(empty($mainProf)){
			$mainProf = Role::where('id',$this->user->role_id)->first();
		}
		$otherProf = Specialization::join('roles','roles.id','=','specializations.role_id')->where('user_id',$this->user->id)->where('role_id','!=',$this->user->role_id)->get();
		$userinfo = Userinfo::where('user_id',$this->user->id)->groupBy('user_info.user_id')->first();
		$user = $this->user;

		$albums = Album::select('albums.*',DB::raw('count('.DB::getTablePrefix().'images.id) as imgcount'))->leftjoin('images','images.album_id','=','albums.id')->where('albums.user_id',$this->user->id)->groupby('albums.id')->get();
		if(!empty($albums)){
			foreach ($albums as $key => $val) {
				$albums[$key]->images = Image::where('album_id',$val->id)->get();
			}
		}

		if(!empty($userinfo) && Auth::check() && $user->id!=Auth::user()->id){
			Userinfo::increment('enters_count',0.5);
			if(round($userinfo->enters_count)%10==0){
				$this->saveRating();
			}
		}
		return View::make('content.front.profile.photo',compact('mainProf','otherProf','user','userinfo','registerdTime','albums'));
	}

	private function saveRating(){
		$model = new Ratinghistory;

		$startToday = date('Y-m-d 00:00:00');
		$endToday = date('Y-m-d 23:59:59');
		$todayRatingCount = $model->where('user_id',$this->user->id)
			->where('type','profileview')
			->whereBetween('created_at', array($startToday,$endToday))
			->count();
		
		if($todayRatingCount < 2){
			$model->user_id = $this->user->id;
			$model->user_type = $this->user->role_id==2?'customer':'performer';
			$model->amount = 1;
			$model->type = 'profileview';
			$model->save();

			$userInfo = Userinfo::where('user_id',$this->user->id)->first();
			$newRating = $userInfo->rating+1;
			$userInfo->update(array('rating'=>$newRating));
		}
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
		$reviews = Review::select('users.alias','users.online','projects.title as project_title','user_info.*','reviews.*')
		->leftjoin('projects','projects.id','=','reviews.project_id')
		->leftjoin('user_info','user_info.user_id','=','reviews.from_user')
		->leftjoin('users','users.id','=','reviews.from_user')
		->orderBy('reviews.id','DESC')
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
		$dates = Calendar::where('user_id',$this->user->id)->get();
		return View::make('content.front.profile.calendar',compact('dates'));
	}	
}