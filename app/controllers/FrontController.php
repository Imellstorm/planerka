
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

	public function search(){
		$spec 	= Input::get('specialization');
		$city 	= Input::get('city');
		$date 	= Input::get('date');
		$budjet = Input::get('budjet');

		$result = User::join('user_info','user_info.user_id','=','users.id')
					  ->leftjoin('specializations','specializations.user_id','=','users.id')
					  ->where('users.role_id','!=',2);

		if(!empty($spec)){
			$result->where('specializations.role_id',$spec);
		} else {
			$result->groupBy('users.id');
		}

		if(!empty($city)){
			$result->where('user_info.city',$city);
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

		//$result->where('calendar.date','!=','2015-05-26');

		$result = $result->paginate(16)
						 ->appends(array(
						 	'spec' 	=> $spec, 
						 	'city' 	=> $city, 
						 	'date' 	=>$date, 
						 	'budjet'=> $budjet,
						 ));

		if(count($result)){
			foreach ($result as $key => $val) {
				$val->specializations = Specialization::where('user_id',$val->user_id)->join('roles','roles.id','=','specializations.role_id')->get();
				$val->albums = Album::where('user_id',$val->user_id)->get();
				$val->reviews = Review::where('to_user',$val->user_id)->count();
				$val->projects = Userstoproject::where('user_id',$val->user_id)->where('status',6)->count();
			}
		}

		$hideDel = true;
		return View::make('content.front.search',compact('result','hideDel'));
	}
}
