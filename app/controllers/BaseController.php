<?php

class BaseController extends Controller {

	public function __construct(){		
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