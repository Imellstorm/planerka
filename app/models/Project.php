<?php

class Project extends \Eloquent {
    protected $table = 'projects';
    protected $guarded = array('_token');

    public function getAllProjects(){
        $projects =  DB::table($this->table)
            ->where('closed','!=',1)
            ->where('status','')
            ->orderBy('id','DESC')
            ->paginate(10);
        return $projects;
    }

    public function getProjectsByUser($userId){
        $projects =  DB::table($this->table)
            ->select('user_info.*',DB::raw('count('.DB::getTablePrefix().'project_messages.id) as new_messages'),$this->table.'.*')
            ->leftjoin('user_info','user_info.user_id','=',$this->table.'.user_id')
            ->leftjoin('project_messages','project_messages.project_id','=',DB::raw(DB::getTablePrefix().$this->table.'.id AND '.DB::getTablePrefix().'project_messages.readed=0 AND '.DB::getTablePrefix().'project_messages.to_user='.$userId))
            ->where($this->table.'.user_id',$userId)
            ->orderBy($this->table.'.id','DESC')
            ->groupBy($this->table.'.id')
            ->paginate(10);
        return $projects;
    }

    public function getAcceptedProjects($userId){
        $projects =  DB::table('users_to_project')
            ->select($this->table.'.*','reviews.id as review','user_info.name','user_info.surname','user_info.city','user_info.pro','users.alias','users_to_project.status','users_to_project.id as users_to_project_id',$this->table.'.city as project_city')
            ->leftjoin($this->table,'users_to_project.project_id','=',$this->table.'.id')
            ->leftjoin('user_info','user_info.user_id','=',$this->table.'.user_id')
            ->leftjoin('users','users.id','=',$this->table.'.user_id')
            ->leftjoin('reviews','reviews.project_id','=',DB::raw(DB::getTablePrefix().'users_to_project.project_id AND '.DB::getTablePrefix().'reviews.from_user = '.DB::getTablePrefix().'users_to_project.user_id'))
            ->where('users_to_project.user_id',$userId)
            ->orderBy($this->table.'.id','DESC')
            ->paginate(10);
        return $projects;
    }

    public function getProject($id){
        $project = DB::table($this->table)
        ->select(
            $this->table.'.*',
            $this->table.'.id as project_id',
            'user_info.*',
            'users.created_at as usercreated',
            'users.alias',
            'roles.name as rolename',
            $this->table.'.city as project_city')
        ->leftjoin('user_info','user_info.user_id','=',$this->table.'.user_id')
        ->leftjoin('users','users.id','=',$this->table.'.user_id')
        ->leftjoin('roles','roles.id','=',$this->table.'.role_id')
        ->where($this->table.'.id',$id)
        ->first();
        return $project;
    }

}