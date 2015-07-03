<?php
class SettingsController extends BaseController {
  protected $rules = array(
    'newpass'     => 'same:passconf',
    'email'       => 'max:128|email',
  );


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function postStore()
  { 
    $validator = Validator::make(Input::all(), $this->rules, array('same'=>'новый пароль не совпадает с подтверждением'));
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
      
      $model->save();
    }
      $userUpdateResult = $this->updateUser();
      if(isset($userUpdateResult['errors'])){
        return Redirect::back()->withErrors($userUpdateResult['errors']);
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
    
    $validator = Validator::make($data = Input::all(), $this->rules, array('same'=>'новый пароль не совпадает с подтверждением'));
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
          );          
          $model->update($data);

          $userUpdateResult = $this->updateUser();
          if(isset($userUpdateResult['errors'])){
            return Redirect::back()->withErrors($userUpdateResult['errors']);
          };
    }
    $view = View::make('content.front.messagebox',array('message'=>'Настройки обновлены!'))->render();
        return Redirect::back()->with('message', $view);
  }

  private function updateUser(){
    $model = User::find(Auth::user()->id);
    $updateData = array();

    $newpass = Input::get('newpass'); 
    if(!empty($newpass) && Hash::check(Input::get('oldpass'),Auth::user()->password) ){
      $updateData['password']  = Hash::make($newpass);    
    } elseif(!empty($newpass)) {
      return array('errors'=>array('oldpass'=>'Неверный старый пароль'));
    }

    $newmail = Input::get('email');
    if(!empty($newmail)){
       $updateData['email']  = $newmail;
    }

    if(!empty($updateData)){
      $model->update($updateData);
    }

  }
}