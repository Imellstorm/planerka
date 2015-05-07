<?php

class RemindersController extends Controller {


  /**
   * Handle a POST request to remind a user of their password.
   *
   * @return Response
   */
  public function postRemind()
  {
    $token = str_random(40);
    $email = Input::get('email');
    $user = User::where('email',$email)->first();
    if(empty($user)){
      $view = View::make('content.front.messagebox',array('message'=>'Неверный email'))->render();
      return Redirect::back()->with('message', $view);
    }

    $mailSended = mail($email, 'Восстановление пароля', 'Для восстановления пароля на сайте '.URL::to('/').' перейдите по ссылке '.URL::to('/').'/password/reset/'.$token);
    
    if($mailSended){
      $user->update(array('password_remind'=>$token));
      $message = 'Интструкция для восстановления пароля выслана не email';
    } else {
      $message = 'Не удалось отправить почту';
    }
    $view = View::make('content.front.messagebox',array('message'=>$message))->render();
    return Redirect::back()->with('message', $view);
  }

  /**
   * Display the password reset view for the given token.
   *
   * @param  string  $token
   * @return Response
   */
  public function getReset($token = null)
  {
    if (is_null($token)) App::abort(404);
    return Redirect::to('/')->with('token', $token);
  }

  /**
   * Handle a POST request to reset a user's password.
   *
   * @return Response
   */
  public function postReset()
  {
    $rules = array(
      'token'     => 'required',
      'password'  => 'required|same:password_confirmation|max:256',
    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()){
      return Response::json($validator->messages());
    }
    $user = User::where('password_remind',Input::get('token'))->first();
    if(empty($user)){
      return Response::json(array('password'=>'Неверный токен'));
    }
    $user->update(array('password'=>Hash::make(Input::get('password')),'password_remind'=>''));
    return Response::json(array('success'=>'success','view'=>'<div style="color:green; width:200px; margin:40px 0 0 0px; text-align:center;">Пароль изменён</div>'));
  }
}
?>