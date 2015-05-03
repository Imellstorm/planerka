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

    public function getLoginfacebook()
    {
        $providerData = Config::get('oauth-4-laravel.consumers.facebook');
        if(empty($providerData)){
            App::abort(404);
        }
        // get data from input
        $code = Input::get( 'code' );

        // get fb service
        $fb = OAuth::consumer( 'facebook','planerka.appteka.cc/auth/loginfacebook' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $fb->request( '/me' ), true );

            $message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
            echo $message. "<br/>";

            //Var_dump
            //display whole array().
            dd($result);

        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }
    }
 
}