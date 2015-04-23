<?php

class PayController extends BaseController {

	/**
	* Procces pay info from Liqpay and put funds to user balance 
	*
	*/
	public function Payprocess(){
		$data = Input::get('data');
		$signature = Input::get('signature');

		if(!empty($data) && !empty($signature)){
			$data = json_decode(base64_decode($data));
			$order = Order::find($data->order_id);
			
			if(!empty($order) && $order->status!='paid' && ($data->status=='success' || $data->status=='sandbox')){
				$order->status = 'paid';
				$order->update();

				$user = User::find($order->user_id);
				$user->balance = $user->balance+$data->amount;
				$user->update();
			}
		}
	}

}