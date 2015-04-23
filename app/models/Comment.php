<?php

class Comment extends Eloquent {

	/**
	 * Нужен для работы Input::all().
	 *
	 * @var array
	 */
	protected $guarded = array('_token');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comments';

	
	/**
	 * get comments for single post by post id
	 *
	 * @var Obj
	 */
	public function getPostComments($postId){
		return DB::table($this->table)
				->select('comments.*','users.username','users.id as user_id')
				->join('users','users.id', '=', 'comments.user_id')
				->where('post_id',$postId)
				->orderBy('comments.created_at', 'desc')
				->paginate(10);
	}

	/**
	 * get last comments comments for active posts
	 *
	 * @var Obj
	 */
	public function getLastComments(){
		$postKeepDays = Settings::first()->post_keep_front;
		return DB::table($this->table)
				->select('comments.*')
				->join('posts','posts.id','=','comments.post_id')
				->where('posts.created_at','>',date('Y-m-d H:i:s', time() - (60*60*24*$postKeepDays) ))
				->take(3)
				->orderby('comments.id','DESC')
				->get();
	}

	/**
	 * get comments for single user
	 *
	 * @var Obj
	 */
	public function getUserComments($userId,$table_fields,$params){

		$sort = $params['sort'];
    	$order = $params['order'];
    	$field = $params['field'];
    	$search = $params['search'];
    	$sort_by = isset($table_fields[$sort])?$table_fields[$sort]:'comments.id';  //set default sort
    	isset($table_fields[$field])?$search_field=$table_fields[$field]:$search_field='comments.id';

    	$comments =  DB::table($this->table)
    					->select('comments.*','posts.title as post')
    					->join('posts','posts.id','=','comments.post_id')
    					->where('comments.user_id',$userId)
    					->where($search_field,'like','%'.$search.'%')
    					->orderBy($sort_by,$order)
    					->paginate(10)
						->appends(array('sort' => $sort, 'order' => $order, 'field' =>$field, 'search' => $search));
        return $comments;
	}

	/**
	 * get all comments
	 *
	 * @var Obj
	 */
	public function getComments($table_fields,$params){

		$sort = $params['sort'];
    	$order = $params['order'];
    	$field = $params['field'];
    	$search = $params['search'];
    	$sort_by = isset($table_fields[$sort])?$table_fields[$sort]:'comments.id';  //set default sort
    	isset($table_fields[$field])?$search_field=$table_fields[$field]:$search_field='comments.id';

    	$comments =  DB::table($this->table)
    					->select('comments.*','users.username','posts.title as post')
    					->join('users','comments.user_id','=','users.id')
    					->join('posts','comments.post_id','=','posts.id')
    					->where($search_field,'like','%'.$search.'%')
    					->orderBy($sort_by,$order)
    					->paginate(20)
						->appends(array('sort' => $sort, 'order' => $order, 'field' =>$field, 'search' => $search));
        return $comments;
	}	

}