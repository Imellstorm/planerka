<?php

class Article extends \Eloquent {
	
	protected $table = 'articles';
	protected $guarded = array('_token');

  	public function User()
	{
		return $this->belongsTo('User');
	}

  	public function Folder()
	{
		return $this->belongsTo('Folder');
	}

	public function getArticles($table_fields,$params){
		$sort = $params['sort'];
    	$order = $params['order'];
    	$field = $params['field'];
    	$search = $params['search'];
    	$sort_by = isset($table_fields[$sort])?$table_fields[$sort]:'id';  //set default sort
    	isset($table_fields[$field])?$search_field=$table_fields[$field]:$search_field='articles.id';

    	$articles =  DB::table('articles')
    					->join('users', 'users.id', '=', 'articles.user_id')
    					->select('articles.*', 'users.username as user')
    					->where($search_field,'like','%'.$search.'%')
    					->orderBy($sort_by,$order)
    					->paginate(20)
						->appends(array('sort' => $sort, 'order' => $order, 'field' =>$field, 'search' => $search));

        return $articles;
	}

}