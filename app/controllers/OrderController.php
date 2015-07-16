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
			} else {
				$userInfo->update(array('pro'=>date('Y-m-d',strtotime("+1 month"))));
			}
			$text = 'PRO аккаунт активирован сроком на 1 месяц';
		}
		if($order->type=='promo'){
			if($userInfo->promo > date('Y-m-d')){
				$userInfo->update(array('promo'=>date('Y-m-d',strtotime("+7 days",strtotime($userInfo->promo)))));
			} else {
				$userInfo->update(array('promo'=>date('Y-m-d',strtotime("+7 days"))));
			}
			$text = 'В течении недели ваш профиль будет находиться в первых позициях поиска';
		}
		$order->update(array('status'=>'paid'));

		$view = View::make('content.front.messagebox',array('title'=>'Платёж прошел успешно','message'=>$text))->render();
        return Redirect::to('/account/shop')->with('message', $view);
	}

	public function getFail(){
		$view = View::make('content.front.messagebox',array('title'=>'Платёж не прошел','message'=>'Система приёма платежей не смогла провести ваш платёж'))->render();
        return Redirect::to('/account/shop')->with('message', $view);
	}

}