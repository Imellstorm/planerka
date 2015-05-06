<?php

class ProfileController extends BaseController {
	/**
	 * Show Profile page
	 *
	 * @return Response
	 */
	public function getPhoto(){
		return View::make('content.front.profile.photo');
	}
}