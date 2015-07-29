<?php

class OrderController extends BaseController {

	protected $table_fields = array(
		'Сумма'				=> 'amount',
		'Дата проведения'	=> 'created_at',
	);

	public function getUserOrders($userId=''){
		if(empty($userId)){
			App::abort(404);
		}
		$user = User::find($userId);
		if(empty($user)){
			App::abort(404);
		}
		$model = new Order;
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);
		$table_fields = $this->table_fields;
		$orders = $model->getUserOrders($table_fields,$params,$userId);
		
		return View::make('content.admin.orders.index', compact('orders','user','table_fields'));
	}

	public function getSuccess(){
		// чтение параметров
		$orderId = Input::get('InvId');
		$outSumm = Input::get('OutSum');
		$crc 	 = Input::get('SignatureValue');

		$mrhPass1 = "Qwerty111";
		$crc = strtoupper($crc);
		$myCrc = strtoupper(md5("$outSumm:$orderId:$mrhPass1"));

		$order = Order::where('id',$orderId)->first();

		// проверка корректности подписи и ордера
		if ($myCrc!=$crc || empty($order) || $order->status=='paid'){
			App::abort(404);
		}

		$userInfo = Userinfo::where('user_id',$order->user_id)->first();

		if($order->type=='pro'){
			if($userInfo->pro > date('Y-m-d')){
				$userInfo->update(array('pro'=>date('Y-m-d',strtotime("+1 month",strtotime($userInfo->pro)))));
				$this->saveRating('updatePro',150,'-1 month');
			} else {
				$userInfo->update(array('pro'=>date('Y-m-d',strtotime("+1 month"))));
				$this->saveRating('buyPro',100,'-1 month');
			}
			$text = 'PRO аккаунт активирован сроком на 1 месяц';
		}
		if($order->type=='promo'){
			if($userInfo->promo > date('Y-m-d')){
				$userInfo->update(array('promo'=>date('Y-m-d',strtotime("+7 days",strtotime($userInfo->promo)))));
				$this->saveRating('updatePromo',250,'-1 week');
			} else {
				$userInfo->update(array('promo'=>date('Y-m-d',strtotime("+7 days"))));
				$this->saveRating('buyPromo',50,'-1 week');
			}
			$text = 'В течении недели ваш профиль будет находиться в первых позициях поиска';
		}
		$order->update(array('status'=>'paid'));

		$view = View::make('content.front.messagebox',array('title'=>'Платёж прошел успешно','message'=>$text))->render();
        return Redirect::to('/account/shop')->with('message', $view);
	}

	private function saveRating($type,$amount,$term){
		if(!Auth::check()){
			return false;
		}
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

	public function getFail(){
		$view = View::make('content.front.messagebox',array('title'=>'Платёж не прошел','message'=>'Система приёма платежей не смогла провести ваш платёж'))->render();
        return Redirect::to('/account/shop')->with('message', $view);
	}

}