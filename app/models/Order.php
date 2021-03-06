<?php

class Order extends \Eloquent {
	protected $table = 'orders';
	protected $guarded = array('_token');

	public function getUserOrders($table_fields,$params,$userId){
		$sort = $params['sort'];
    	$order = $params['order'];
    	$field = $params['field'];
    	$search = $params['search'];
    	$sort_by = isset($table_fields[$sort])?$table_fields[$sort]:'id';  //set default sort
    	isset($table_fields[$field])?$search_field=$table_fields[$field]:$search_field='id';

    	$orders =  DB::table($this->table)
    					->select('*')
    					->where($search_field,'like','%'.$search.'%')
    					->where('user_id',$userId)
    					->where('status','paid')
    					->orderBy($sort_by,$order)
    					->paginate(20)
						->appends(array('sort' => $sort, 'order' => $order, 'field' =>$field, 'search' => $search));
        return $orders;
	}
}