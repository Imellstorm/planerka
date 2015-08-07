
<?php

class FrontController extends BaseController {

	public function getIndex(){
		setlocale(LC_ALL, "ru_RU.UTF-8");

		$frontArticles = Article::where('onfront',1)->take(4)->orderBy('id','DESC')->get();

		$blog = new BlogController;
		$blogThemes = $blog->getLastblogthemes('month');

		$vote = Vote::where('active',1)->first();
		if(!empty($vote)){
			if(Auth::check()){
				$userVoted = Votedusers::where('user_id',Auth::user()->id)->where('vote_id',$vote->id)->first();
			} else {
				$userVoted = false;
			}
			$answers = Voteanswer::where('vote_id',$vote->id)->get();
		}

		$frontUsers = User::leftjoin('user_info','user_info.user_id','=','users.id')
			->where('users.onfront',1)
			->orderBy('users.updated_at','DESC')
			->take(4)
			->get();
		if(count($frontUsers)){
			$frontUsers = $this->getAdditionlUsersData($frontUsers);
		}
		$hideDel = true;
		return View::make('content.front.index',compact('frontArticles','blogThemes','vote','answers','userVoted','frontUsers','hideDel'));
	}

	public function page($alias){
		$model = new Article;
		$page  = $model->where('alias',$alias)->first();
		if(empty($page)){
			App::abort(404);
		}
		return View::make('content.front.page',compact('page'));
	}

	public function search(){
		$spec 	= Input::get('specialization');
		$city 	= Input::get('city');
		$date 	= Input::get('date');
		$budjet = Input::get('budjet');

		$promo 	= $this->takeUsers($spec,$city,$date,$budjet,'promo');
		$normal = $this->takeUsers($spec,$city,$date,$budjet,'normal');

		$hideDel = true;
		return View::make('content.front.search',compact('promo','normal','hideDel'));
	}

	private function takeUsers($spec,$city,$date,$budjet,$type){
		$result = User::join('user_info','user_info.user_id','=','users.id')
			  ->where('users.role_id','!=',1)
			  ->where('users.role_id','!=',2);

		if($type=='promo'){
			  $result->where('user_info.promo','>',date('Y-m-d'))
			  		 ->orderBy('user_info.promo','DESC');
		}
		if($type=='normal'){
			  $result->where('user_info.promo','<=',date('Y-m-d'))
			  		 ->orderBy('pro','DESC')
			  		 ->orderBy('rating','DESC');
		}

		if(!empty($spec)){
			$result->leftjoin('specializations','specializations.user_id','=','users.id')
				   ->where('specializations.role_id',$spec);
				   //->orWhere('users.role_id',$spec);
		} 

		if(!empty($city)){
			$result->where('user_info.city',$city);
		}

		if(!empty($date)){
			$result->select('users.*','user_info.*',DB::raw('COUNT('.DB::getTablePrefix().'calendar.id) as cnt'))
				   ->leftjoin('calendar','users.id','=',DB::raw(DB::getTablePrefix().'calendar.user_id AND '.DB::getTablePrefix().'calendar.date = "'.date('Y-m-d',strtotime($date)).'"' )	)
				   ->having('cnt', '=', 0);	 
		}

		if(!empty($budjet)){
			switch ($budjet) {
				case 1:
					$result->where('specializations.price','<',1000);
					break;
				case 2:
					$result->where('specializations.price','>',1000);
					$result->where('specializations.price','<',3000);
					break;
				case 3:
					$result->where('specializations.price','>',3000);
					break;
			}
		}

		$result->groupBy('users.id');
		$result = $result->paginate(16)
						 ->appends(array(
						 	'spec' 	=> $spec, 
						 	'city' 	=> $city, 
						 	'date' 	=> $date, 
						 	'budjet'=> $budjet,
						 ));

		if(count($result)){
			$result = $this->getAdditionlUsersData($result);
		}
		return $result;
	}

	private function getAdditionlUsersData($users){
		foreach ($users as $key => $val) {
			$val->specializations = Specialization::where('user_id',$val->user_id)->join('roles','roles.id','=','specializations.role_id')->get();
			if($val->pro < date('Y-m-d') && $val->specializations[0]->id != $val->role_id){
				unset($users[$key]);
				continue;
			}
			$val->albums = Album::where('user_id',$val->user_id)->get();
			$val->reviews = Review::where('to_user',$val->user_id)->count();
			$val->projects = Userstoproject::where('user_id',$val->user_id)->where('status',6)->count();
		}
		return $users;
	}
}
