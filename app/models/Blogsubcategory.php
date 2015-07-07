<?php

class Blogsubcategory extends \Eloquent {
	protected $table = 'blog_subcategories';
    protected $guarded = array('_token');

    public function getBlogSubCategories($table_fields,$params){
		$sort = $params['sort'];
    	$order = $params['order'];
    	$field = $params['field'];
    	$search = $params['search'];
    	$sort_by = isset($table_fields[$sort])?$table_fields[$sort]:'blog_subcategories.id';  //set default sort
    	isset($table_fields[$field])?$search_field=$table_fields[$field]:$search_field='blog_subcategories.id';

    	$folders =  DB::table($this->table)
    					->select($this->table.'.*','blog_categories.name as parent_name')
    					->leftjoin('blog_categories','blog_categories.id','=',$this->table.'.category_id')
    					->where($search_field,'like','%'.$search.'%')
    					->orderBy($sort_by,$order)
    					->paginate(20)
						->appends(array('sort' => $sort, 'order' => $order, 'field' =>$field, 'search' => $search));

        return $folders;
	}
}