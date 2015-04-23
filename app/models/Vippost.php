<?php

class Vippost extends \Eloquent {
	protected $table = 'vip_posts';

	public function insertVipPosts($days,$postId,$param){
		$insertData = array();
		$user_id = Auth::User()->id;

		foreach ($days as $day) {
			$insertData[]=array('post_id'=>$postId, 'user_id'=>$user_id, 'date'=>$day, 'param'=>$param);
		}
		DB::table($this->table)->insert($insertData);
	}

	public function getBusyDays($postsCount,$param){
		return DB::table('vip_posts')
				->select('date')
				->where('date','>=',date('Y-m-d'))
				->where('param',$param)
				->groupBy('date')
				->havingRaw('COUNT(id)>='.$postsCount)
				->get();
	}
}