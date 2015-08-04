<?php

class BaseController extends Controller {

	public function __construct(){
		$this->getMenus();
		$rules = Article::where('alias','rules')->first();
		$roles = Role::where('show_in_menu',1)->lists('id','name');
        $siteSettings = SiteSettings::first();
		$additionalRoles = Role::where('type','другое')->get();
		if(Auth::check()){
			$this->userInfo = Userinfo::where('user_id',Auth::user()->id)->first();
			$newMessages = Message::where('to',Auth::user()->id)->where('readed',0)->get();
			$newProjectMessages = Projectmessages::leftjoin('projects','projects.id','=','project_messages.project_id')->where('projects.deleted','!=',1)->where('to_user',Auth::user()->id)->where('readed',0)->get();
			$newNotifications = Notifications::where('to_user',Auth::user()->id)->where('readed',0)->get();
			View::share('newProjectMessages',count($newProjectMessages));
			View::share('newNotifications',count($newNotifications));
			View::share('newMessages',count($newMessages));

			View::share('userInfo',$this->userInfo);
		} else {
			View::share('rules',$rules);
		}
		View::share('additionalRoles',$additionalRoles);
		View::share('roles',$roles);
        View::share('siteSettings',$siteSettings);
		
		Auth::viaRemember();
		$this->setOnline();
    }

    private function setOnline(){
    	if(Auth::check()){
    		$user = User::find(Auth::user()->id);
    		$user->update(array('online'=>1));
    		$this->updateRatingDayActivity();
    		$this->updateRatingSpecialization();	
    	}
    }

    public function setOffline(){
    	if(Auth::check()){
    		$user = User::find(Auth::user()->id);
    		$user->update(array('online'=>0));
    	}
    }

    private function updateRatingSpecialization(){
        $userInfo = Userinfo::where('user_id',Auth::user()->id)->first();
        if(empty($userInfo)){
            return false;
        }
        if($userInfo->pro > date('Y-m-d')){
            $specCount = Specialization::where('user_id',Auth::user()->id)->count();
            $specRating = Ratinghistory::where('user_id',Auth::user()->id)->where('type','specialization')->orderBy('id','DESC')->first();
            $monthPass = false;
            if(!empty($specRating)){
                $dateNow = new DateTime;
                $date = new DateTime( $specRating->created_at );
                $date->modify( '+1 month' );
                if($date < $dateNow){
                    $monthPass = true;
                }
            }
            if($specCount>1 && (empty($specRating) || $monthPass)){
                $model = new Ratinghistory;
                $model->user_id = Auth::user()->id;
                $model->user_type = Auth::user()->role_id==2?'customer':'performer';
                $model->amount = 25;
                $model->type = 'specialization';
                $model->save();

                $newRating = $userInfo->rating+25;
                $userInfo->update(array('rating'=>$newRating));
            }            
        }
    }

    private function updateRatingDayActivity(){
        $userInfo = Userinfo::where('user_id',Auth::user()->id)->first();
        if(empty($userInfo)){
            return false;
        }
        $rating = Ratinghistory::where('user_id',Auth::user()->id)->where('type','dayactivity')->orderBy('id','DESC')->first();
        $dayPass = false;
        if(!empty($rating)){
        	$dateNow = new DateTime;
            $date = new DateTime( $rating->created_at );
            $date->modify( '+1 day' );
            if($date < $dateNow){
                $dayPass = true;
            }
        }
        if(empty($rating) || $dayPass){
            $model = new Ratinghistory;
            $model->user_id = Auth::user()->id;
            $model->user_type = Auth::user()->role_id==2?'customer':'performer';
            $model->amount = 1;
            $model->type = 'dayactivity';
            $model->save();

            $newRating = $userInfo->rating+1;
            $userInfo->update(array('rating'=>$newRating));
        }
    }

    public function isPro(){
    	if($this->userInfo->pro >= date('Y-m-d')){
    		return true;
    	}
    	return false;
    }

    public function getUserinfo($userId=''){
    	if(empty($userId)){
    		if(Auth::check()){
				$userId = Auth::user()->id;
			}
    	}
    	$userInfo = Userinfo::select('user_info.*','users.alias','users.role_id')
	    	->leftjoin('users','users.id','=','user_info.user_id')
	    	->where('user_info.user_id',$userId)
	    	->first();
	    if(!empty($userInfo)){
	    	$userInfo->profs = Specialization::leftjoin('roles','roles.id','=','specializations.role_id')->where('specializations.user_id',$userInfo->user_id)->get();
		}
		View::share('userInfo',$userInfo);
    }

    private function getMenus(){
		$result = Menu::all();
		$menus = new stdClass();
		
		foreach ($result as $value) {
			$key = $value->name;
			$menus->$key = $value->content;
		}
		View::share('menu', $menus);
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Chek user is admin
	 * @return bool
	 */
	protected function is_admin(){
		if(Auth::check() && Auth::user()->role->id==1){
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Chek is user resource owner
	 * @return bool
	 */
	protected function is_owner($elementOwnerId){
		if($this->is_admin() || Auth::check() && $elementOwnerId==Auth::user()->id){
			return true;
		} else {
			return false;
		}
	}

}