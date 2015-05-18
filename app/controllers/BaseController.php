<?php

class BaseController extends Controller {

	public function __construct(){
		$this->getMenus();
		$rules = Article::where('alias','rules')->first();
		$roles = Role::where('show_in_menu',1)->lists('id','name');
		if(Auth::check()){
			$userInfo = Userinfo::where('user_id',Auth::user()->id)->first();
			View::share('userInfo',$userInfo);
		}
		View::share('rules',$rules);
		View::share('roles',$roles);
    }

    public function getUserinfo($userId=''){
    	if(empty($userId)){
			$userId = Auth::user()->id;
    	}
    	$userInfo = Userinfo::select('user_info.*','users.alias')
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