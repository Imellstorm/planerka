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
                return Redirect::intended('/');
            } else {
                Auth::logout();
                $view = View::make('content.front.messagebox',array('message'=>'Вы не можете зайти так как у вас не подтверждён email. <br>Проверте вашу почту.'))->render();
                return Redirect::back()->with('message', $view);
            }
        }
        $view = View::make('content.front.messagebox',array('message'=>'Неверный логин или пароль.'))->render();
        return Redirect::back()->with('message', $view);
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
            //https://graph.facebook.com/1392864781040177/picture?type=large

            if(isset($result['id']) && !empty($result['id'])){
                if(!empty($create)){
                    return Redirect::to('/')
                    ->with('socId',$result['id'])
                    ->with('socNetwork','facebook')
                    ->with('socImage','https://graph.facebook.com/'.$result['id'].'/picture?type=large');
                } else {
                    $result = $this->socLogin('facebook',$result->uid);
                    if(isset($result['success'])){
                        return Redirect::to('/');
                    }
                    $view = View::make('content.front.messagebox',array('message'=>'Вы не смогли зайти через Facebook.'))->render();
                    return Redirect::to('/')->with('message', $view);
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

            $params = array(
                'client_id' => Config::get('oauth-4-laravel.consumers.vkontakte.client_id'),
                'client_secret' => Config::get('oauth-4-laravel.consumers.vkontakte.client_secret'),
                'code' => $code,
                'redirect_uri' => URL::to('/').'/auth/loginvk/'.$create
            );
            $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
            $graph_url = "https://api.vk.com/method/users.get?access_token=".$token['access_token']."&uids=".$token['user_id']."&fields=first_name,last_name,country,city,photo_medium,photo_big,bdate,photo_rec,about,screen_name,contacts";
            $params = file_get_contents($graph_url);
            $param = json_decode($params);
            $result = $param->response[0];
            if(isset($result->uid) && !empty($result->uid)){
                if(!empty($create)){
                    return Redirect::to('/')
                    ->with('socId',$result->uid)
                    ->with('socNetwork','vk')
                    ->with('socImage',$result->photo_medium);
                } else {
                    $result = $this->socLogin('vk',$result->uid);
                    if(isset($result['success'])){
                        return Redirect::to('/');
                    }
                    $view = View::make('content.front.messagebox',array('message'=>$result['error']))->render();
                    return Redirect::to('/')->with('message', $view);
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
                    return Redirect::to('/')
                    ->with('socId',$result['id'])
                    ->with('socNetwork','twitter')
                    ->with('socImage',$result['profile_image_url']);
                } else {
                    $result = $this->socLogin('twitter',$result->uid);
                    if(isset($result['success'])){
                        return Redirect::to('/');
                    }
                    $view = View::make('content.front.messagebox',array('message'=>'Вы не смогли зайти через Twitter.'))->render();
                    return Redirect::to('/')->with('message', $view);
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
            if($user->email_verify!=1){
                 return array('error'=>'Вы не можете войти до тех пор пока не подтвердите почту. Проверте ваш Email.');
            }
            Auth::login($user);
            if (Auth::check()){
                return array('success'=>true);
            }
        }
        return array('error'=>'Вы не можете войти с через '.$network);
    }
 
}