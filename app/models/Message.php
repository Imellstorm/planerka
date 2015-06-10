<?php

class Message extends \Eloquent {
	protected $table = 'messages';
    protected $fillable = array('from_del', 'to_del');

    public function getUserMessages($currentUserId,$userId){
        $result = DB::table($this->table)
                    ->select('user_info.*','users.alias',$this->table.'.*')
                    ->leftjoin('user_info','user_info.user_id','=',$this->table.'.from')
                    ->leftjoin('users','users.id','=',$this->table.'.from')
                    ->where('from',$currentUserId)
                    ->where('to',$userId)  
                    ->orWhere('from',$userId)
                    ->where('to',$currentUserId)
                    ->orderBy($this->table.'.id','DESC')
                    ->paginate(20);
        return $result;
    }

    public function getUserDialogs($userId){
        $result = DB::table($this->table)
                    ->select('user_info.*','users.alias',$this->table.'.*')
                    ->leftjoin('user_info','user_info.user_id','=',$this->table.'.from')
                    ->leftjoin('users','users.id','=',$this->table.'.from')
                    ->where('to',$userId)  
                    ->orWhere('from',$userId)
                    ->orderBy($this->table.'.id','DESC')
                    ->get();

        foreach($result as $key=>$val){
            if($val->to==$userId){
                $val->userdialog = $val->from_name;
                $dialogs[$val->from][]=$val;
            } else {
                $val->userdialog = $val->to_name;
                $dialogs[$val->to][]=$val;
            }
        }
        return $dialogs;
    }

	public function getMessagesInbox($table_fields,$params,$id){        
		$sort = $params['sort'];
    	$order = $params['order'];
    	$field = $params['field'];
    	$search = $params['search'];
    	$sort_by = isset($table_fields[$sort])?$table_fields[$sort]:'id';  //set default sort
    	isset($table_fields[$field])?$search_field=$table_fields[$field]:$search_field='id';

    	$messages =  DB::table($this->table)
    					->select('*')
                        ->where('to',$id)
                        ->where('to_del','!=',1)
    					->where($search_field,'like','%'.$search.'%')
    					->orderBy($sort_by,$order);

    	return $messages->paginate(20)->appends(array('sort' => $sort, 'order' => $order, 'field' =>$field, 'search' => $search));
	}

    public function getMessagesOutbox($table_fields,$params,$id){        
        $sort = $params['sort'];
        $order = $params['order'];
        $field = $params['field'];
        $search = $params['search'];
        $sort_by = isset($table_fields[$sort])?$table_fields[$sort]:'id';  //set default sort
        isset($table_fields[$field])?$search_field=$table_fields[$field]:$search_field='id';

        $messages =  DB::table($this->table)
                        ->select('*')
                        ->where('from',$id)
                        ->where('from_del','!=',1)
                        ->where($search_field,'like','%'.$search.'%')
                        ->orderBy($sort_by,$order);

        return $messages->paginate(20)->appends(array('sort' => $sort, 'order' => $order, 'field' =>$field, 'search' => $search));
    }
}