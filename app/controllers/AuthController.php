<?php
 
class AuthController extends BaseController {
 
    public function getIndex()
    {
        return View::make('content.auth.login');
    }

    public function getAjax()
    {
        return View::make('content.auth.ajax_login');
    }
 
    public function postIndex()
    {
        $username = Input::get('username');
        $password = Input::get('password');
 
        if (Auth::attempt(array('email' => $username, 'password' => $password)))
        {
            if(Auth::user()->email_verify == 1){
                if(Auth::user()->role->id == 1){
                    return Redirect::intended('admin/users');
                }else{
                    Session::flash('success', 'Вы вошли как '.Auth::User()->username);
                    return Redirect::intended('/account');
                }
            } else {
                return Redirect::back()
                //->withInput()
                ->withErrors('Вы не можете зайти так как у вас не подтверждён email. Проверте вашу почту.');
            }
        }
        return Redirect::back()
            ->withInput()
            ->withErrors('Неверный логин или пароль.');
    }
 
    public function getLogin()
    {
        return Redirect::to('/auth');
    }
 
    public function getLogout()
    {
        Auth::logout(); 
        return Redirect::to('/');
    }
 
}