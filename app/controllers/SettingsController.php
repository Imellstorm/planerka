<?php
class SettingsController extends BaseController {
  protected $rules = array(
    'newpass' => 'same:passconf',
  );
  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function postStore()
  { 
    $validator = Validator::make(Input::all(), $this->rules);
    if ($validator->fails()){
      return Redirect::back()->withErrors($validator)->withInput(Input::except('newpass','passconf','oldpass'));
    } else {
      $adminmail = Input::get('adminmail');
      $blogmail = Input::get('blogmail');
      $privatemail = Input::get('privatemail');

      $model = new Usersettings;
      $model->user_id     = Auth::user()->id;
      $model->adminmail   = $adminmail?$adminmail:0;
      $model->blogmail    = $blogmail?$blogmail:0;
      $model->privatemail = $privatemail?$privatemail:0;
      //$model->projectsmail= Input::get('projectsmail');
      $model->save();
    }
      if(!$this->updatePassword()){
        return Redirect::back()->withErrors(array('oldpassword'=>'Неверный старый пароль'));
      };  
    $view = View::make('content.front.messagebox',array('message'=>'Настройки сохранены!'))->render();
        return Redirect::back()->with('message', $view);
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function putUpdate($id)
  { 
    $model = Usersettings::find($id);
    if(empty($model)){
      App::abort(404);
    }
    
    $validator = Validator::make($data = Input::all(), $this->rules);
    if ($validator->fails()){
      return Redirect::back()->withErrors($validator)->withInput(Input::except('newpass','passconf','oldpass'));
    } else {
      $adminmail = Input::get('adminmail');
      $blogmail = Input::get('blogmail');
      $privatemail = Input::get('privatemail');

      $data = array(
            'adminmail'     => $adminmail?$adminmail:0,
            'blogmail'      => $blogmail?$blogmail:0,            
            'privatemail'   => $privatemail?$privatemail:0,
            //'projectsmail'  => Input::get('projectsmail')?Input::get('blogmail'):0,
          );          
          $model->update($data);
          if(!$this->updatePassword()){
            return Redirect::back()->withErrors(array('oldpassword'=>'Неверный старый пароль'));
          };
    }
    $view = View::make('content.front.messagebox',array('message'=>'Настройки обновлены!'))->render();
        return Redirect::back()->with('message', $view);
  }
  private function updatePassword(){
    $newpass = Input::get('newpass');
    if(empty($newpass)){
      return true;
    }
    if( Hash::check( Input::get('oldpass'),Auth::user()->password) ){
      $model = User::find(Auth::user()->id);
      $model->update(array(
        'password'  =>  Hash::make($newpass),
      ));
      return true;
    }
    return false;
  }
}