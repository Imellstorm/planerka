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
		View::share('user',$this->user);
    }

	/**
	 * Show Profile photo page
	 *
	 * @return Response
	 */
	public function getPhoto(){
		$mainProf = Specialization::join('roles','roles.id','=','specializations.role_id')->where('role_id',$this->user->role_id)->where('user_id',$this->user->id)->first();
		$otherProf = Specialization::join('roles','roles.id','=','specializations.role_id')->where('user_id',$this->user->id)->where('role_id','!=',$this->user->role_id)->get();
		$userinfo = Userinfo::where('user_id',$this->user->id)->first();
		$user = $this->user;

		$startTime = new Datetime($this->user->created_at);
		$endTime = new DateTime();	 
		$diff = $endTime->diff($startTime);
		$date = new stdClass;
		$date->years = $diff->format('%y');
		$date->months = $diff->format('%m');
		$date->days = $diff->format('%d');

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
		return View::make('content.front.profile.photo',compact('mainProf','otherProf','user','userinfo','registerdTime','date','albums'));
	}

	/**
	 * Show Profile video page
	 *
	 * @return Response
	 */
	public function getVideo(){
		return View::make('content.front.profile.video');
	}

	/**
	 * Show Profile Reviews page
	 *
	 * @return Response
	 */
	public function getReviews(){
		return View::make('content.front.profile.reviews');
	}

	/**
	 * Show Profile calendar page
	 *
	 * @return Response
	 */
	public function getCalendar(){
		return View::make('content.front.profile.calendar');
	}	
}