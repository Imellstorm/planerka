<?php

class Projectmessages extends \Eloquent {
	protected $table = 'project_messages';
    protected $guarded = array('_token');

    public function getProjectMessagesByUser($projectId,$userId,$toArray=false){
    	$this->userId = $userId;
    	if($toArray) DB::setFetchMode(PDO::FETCH_ASSOC);
		$result = DB::table($this->table)
					->select('users.alias','users.online','users.role_id','user_info.*',$this->table.'.*')
					->leftjoin('user_info','user_info.user_id','=',$this->table.'.from_user')
					->leftjoin('users','users.id','=',$this->table.'.from_user')
					->where($this->table.'.project_id',$projectId)
					->where(function($query){
							$query->where($this->table.'.from_user',$this->userId)
								  ->orWhere($this->table.'.to_user',$this->userId);
					})
					->orderby($this->table.'.id','DESC')
					->get();
		if($toArray) DB::setFetchMode(PDO::FETCH_CLASS);
		return $result;
    }
}