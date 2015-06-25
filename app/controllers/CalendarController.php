<?php

class CalendarController extends BaseController {

	public function postStore(){
		$model = new Calendar;
		$model->where('user_id',Auth::user()->id)->where('system','!=',1)->delete();
		$dates = Input::get('dates');

		if(!empty($dates)){	
			$dates = explode(',',$dates);	
	    	foreach ($dates as $key => $val) {
	    		$datesArray[] = array(
	    			'user_id'	=> Auth::user()->id,
	    			'date'		=> date('Y-m-d',strtotime($val)),
	    		);
	    	}
	    	$model->insert($datesArray);
	    }

    	return Redirect::back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$model = Video::find($id);
		if(!empty($model) && $this->is_owner($model->user_id)){
			Video::destroy($model->id);
			return Redirect::back();
		}
		return Redirect::back()->withErrors(array('Вы не можете удалить это видео!'));
	}

}