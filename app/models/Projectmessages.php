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
							$query->where('project_messages.from_user',$this->userId)
								  ->orWhere('project_messages.to_user',$this->userId);
					})
					->orderby($this->table.'.id','DESC');
		if($toArray){ 
			$result = $result->get();
			DB::setFetchMode(PDO::FETCH_CLASS);
		} else {
			$result = $result->paginate(10);
		}
		return $result;
    }
}