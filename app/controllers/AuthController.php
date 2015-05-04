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

    public function getLoginfacebook($create=''){
        // get data from input
        $code = Input::get( 'code' );

        // get fb service
        $fb = OAuth::consumer( 'facebook', URL::to('/').'/auth/loginfacebook/'.$create );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $fb->request( '/me' ), true );
            if(isset($result['id']) && !empty($result['id'])){
                if(!empty($create)){
                    return Redirect::to('/')->with('socId',$result['id'])->with('socNetwork','facebook');
                } else {
                    if($this->socLogin('facebook',$result['id'])){
                        return Redirect::to('/account');
                    }
                    return Redirect::to('/')->with('error','Вы не смогли авторизироваться через Facebook');
                }
            } 

        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }
    }

    public function getLoginvk($create=''){
        // get data from input
        $code = Input::get( 'code' );

        // get vk service
        $vk = OAuth::consumer( 'vkontakte', URL::to('/').'/auth/loginvk/'.$create );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from facebook, get the token
            $result = $vk->requestAccessToken( $code );
            var_dump($result);exit;
            if(isset($result->user_id) && !empty($result->user_id)){
                if(!empty($create)){
                    return Redirect::to('/')->with('socId',$result->user_id)->with('socNetwork','vk');
                } else {
                    if($this->socLogin('vk',$result->user_id)){
                        return Redirect::to('/account');
                    }
                    return Redirect::to('/')->with('error','Вы не смогли авторизироваться через VKontakte');
                }
            } 

        }
        // if not ask for permission first
        else {
            $url = $vk->getAuthorizationUri();
            return Redirect::to( (string)$url );
        }
    }

    public function getLogintwitter($create=''){
        // get data from input
        $token = Input::get( 'oauth_token' );
        $verify = Input::get( 'oauth_verifier' );

        // get twitter service
        $tw = OAuth::consumer( 'twitter', URL::to('/').'/auth/logintwitter/'.$create );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $token ) && !empty( $verify ) ) {

            // This was a callback request from twitter, get the token
            $token = $tw->requestAccessToken( $token, $verify );

            // Send a request with it
            $result = json_decode( $tw->request( 'account/verify_credentials.json' ), true );
            
            if(isset($result['id']) && !empty($result['id'])){
                if(!empty($create)){
                    return Redirect::to('/')->with('socId',$result['id'])->with('socNetwork','twitter');
                } else {
                    if($this->socLogin('twitter',$result['id'])){
                        return Redirect::to('/account');
                    }
                    return Redirect::to('/')->with('error','Вы не смогли авторизироваться через Twitter');
                }
            }       
        }
        // if not ask for permission first
        else {
            // get request token
            $reqToken = $tw->requestRequestToken();

            // get Authorization Uri sending the request token
            $url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

            // return to twitter login url
            return Redirect::to( (string)$url );
        }
    }

    private function socLogin($network,$id){
        $user = User::where('socnet',$network)->where('socid',$id)->first();
        if(!empty($user)){
            Auth::login($user);
            if (Auth::check()){
                return true;
            }
        }
        return false;
    }
 
}