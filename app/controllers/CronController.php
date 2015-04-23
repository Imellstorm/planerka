<?php

class CronController extends BaseController {
/**
*	Делает Email рассылку
*	$key string
*	@return response
*/
	public function getSendmails($key=''){
		if(!empty($key) && $key=='Fbg3Eds4'){
			$users = User::where('get_mail',1)->get();
			if(!empty($users)){							// если есть кому рассылать
				$posts = Post::where('created_at','>',date('Y-m-d H:i:s',strtotime('now -7 day')))->orderby('id','DESC')->get();
				$headers = "From: Firm Market <no-reply@mail.appteka.cc>"; 
				$headers.= "\r\nContent-Type: text/html;";
				if(!empty($posts)){						// если есть что рассылать
					$text = View::make('emails.lastposts',compact('posts'))->render();;				
					foreach ($users as $user) {
						mail($user->email, 'Новые объявления', $text, $headers);		
					}
				}
			}
		}
	}
}