<?php

class FavoritesController extends BaseController {

	public function getSave($userAlias=''){
		if(empty($userAlias)){
			echo '<div class="text-center" style="padding:30px 20px 0 20px">Нет имени добавляемого пользователя</div>';
			exit;
		}
		$selectedUser = User::where('alias',$userAlias)->first();
		if(empty($selectedUser)){
			echo '<div class="text-center" style="padding:30px 20px 0 20px">Добавляемый пользователь не найден</div>';
			exit;
		}
		$model = new Favorites;
		$exist = $model->where('selected_user_id',$selectedUser->id)->where('user_id',Auth::user()->id)->first();
		if(!empty($exist)){
			echo '<div class="text-center" style="padding:30px 20px 0 20px">Данный пользователь уже добавлен в избранное</div>';
			exit;
		}

		$model->user_id = Auth::user()->id;
		$model->selected_user_id = $selectedUser->id;
		$model->save();

		return Redirect::back();
		//echo '<div class="text-center" style="padding:30px 20px 0 20px">Пользователь добавлен в избанное</div>';
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$model = Favorites::find($id);
		if(!empty($model) && $this->is_owner($model->user_id)){
			Favorites::destroy($model->id);
			return Redirect::back();
		}
		return Redirect::back()->withErrors(array('Вы не можете удалить элемент!'));
	}

}