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
	    $this->saveRating('calendar',1,'-1 week');
    	return Redirect::back();
	}

	private function saveRating($type,$amount,$term){
		$model = new Ratinghistory;

		$endDate = new DateTime;
		$startDate = new DateTime($term);
		
		$monthRatingCount = $model->where('user_id',Auth::user()->id)
			->where('type',$type)
			->whereBetween('created_at', array($startDate->format('Y-m-d H:i:s'),$endDate->format('Y-m-d H:i:s')))
			->count();
		
		if($monthRatingCount == 0){
			$model->user_id = Auth::user()->id;
			$model->user_type = Auth::user()->role_id==2?'customer':'performer';
			$model->amount = $amount;
			$model->type = $type;
			$model->save();

			$userInfo = Userinfo::where('user_id',Auth::user()->id)->first();
			$newRating = $userInfo->rating+$amount;
			$userInfo->update(array('rating'=>$newRating));
		}
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