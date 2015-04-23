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

}