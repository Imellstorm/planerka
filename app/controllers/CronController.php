<?php

class CronController extends BaseController {

	public function getProexpirationreminder($key=''){
		if($key != 'SGtd5K7E47'){
			App::abort(404);
		}
		echo '123';
	}
}