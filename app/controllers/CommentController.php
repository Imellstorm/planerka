<?php

class CommentController extends BaseController {

	protected $rules = array(
	);
	protected $table_fields = array(
			'Автор'					=> 'users.username',
			'Объявление'			=> 'posts.title',	
			'Опубликовано'			=> 'created_at',
		);	

	/**
	* Display a listing of all comments
	*
	* @return Response
	*/
	public function getIndex()
	{
		if($this->is_admin()){
			$model = new Comment;
			$params = array(
				'sort' 		=> Input::get('sort'),
		    	'order' 	=> Input::get('order'),
		    	'field' 	=> Input::get('field'),
		    	'search' 	=> Input::get('search'),
	    	);
			$table_fields = $this->table_fields;

	        $comments = $model->getComments($table_fields,$params);

			return View::make('content.admin.comments.index', compact('comments','table_fields'));
		} else {
			return Redirect::to('/')->withErrors('У вас недостаточно прав!');
		}
	}


	/**
	 * Store a newly created comment in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{	
		$validator = Validator::make(Input::all(), $this->rules);		

		if ($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput();
		} else {			
			$comment = new Comment;

	        $comment->content   	= Input::get('content');
	        $comment->user_id    	= Auth::User()->id;
	        $comment->post_id    	= Input::get('post_id');

        	$res = $comment->save();
		}
		Session::flash('success', 'Комментарий добавлен!');
		
		return Redirect::back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteDestroy($id)
	{
		$comment = Comment::findOrFail($id);
		if($this->is_owner($comment->user_id)){
			Comment::destroy($id);
			if (!Request::ajax()){
				Session::flash('success', 'Комментарий удалён!');
				return Redirect::to('admin/comments');
			}
		}
	}

	public function postAjaxupdate(){
		if (Request::ajax()){
			$id = $_POST['id'];
			$content = $_POST['content'];
			if(!empty($id)){
				$comment = Comment::findOrFail($id);
				if($this->is_owner($comment->user_id)){
					$data['content'] = $content;
					if ($comment->update($data)){
						echo $content;
					} else {
						echo 'Не удалось сохранить';
					}					
				} else {
					echo 'У вас нет прав для изменения данного комментария';
				}
			} 
		}
	}
}

