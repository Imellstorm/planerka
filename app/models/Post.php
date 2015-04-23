<?php

class Post extends Eloquent {

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
	protected $table = 'posts';

    public function getVipPosts($place,$param){        
        $posts =  DB::table('posts')
                        ->leftjoin('city', 'city.id', '=', 'posts.city_id')
                        ->leftjoin('regions', 'regions.id', '=', 'city.region_id')
                        ->leftjoin('vip_posts', 'vip_posts.post_id', '=', 'posts.id')
                        ->leftjoin('users', 'users.id', '=', 'posts.user_id')
                        ->leftjoin('user_status','user_status.id','=','users.status')
                        ->leftjoin('ownership', 'ownership.id', '=', 'posts.ownership')
                        ->leftjoin('comments','comments.post_id','=','posts.id')
                        ->select(
                            'posts.*', 
                            'user_status.name as userstatus', 
                            'user_status.icon as userstatusicon', 
                            'city.name as city', 'regions.name as region', 
                            'regions.id as region_id', 
                            'users.username as author',
                            'ownership.abr as onsabr',
                            'ownership.name as ownership',
                            DB::raw('count('.DB::getTablePrefix().'comments.post_id) as comntcount')
                            )
                        ->where('vip_posts.date', '=', date('Y-m-d'))
                        ->orderBy('vip_posts.id','asc')
                        ->groupby('posts.id');
        if($place == 'region') {
            $posts = $posts->where('vip_posts.param','region')
                           ->where('regions.id',$param);
        } elseif($place == 'city') {
            $posts = $posts->where('vip_posts.param','city')
                           ->where('city.id',$param);
        } else {
            $posts = $posts->where('vip_posts.param','');
        }                     
        return $posts->get();
    }

    public function getRecentPosts($searchParams){
        $postKeepDays = Settings::first()->post_keep_front; 
        $posts =  DB::table('posts')
                ->leftjoin('city', 'city.id', '=', 'posts.city_id')
                ->leftjoin('regions', 'regions.id', '=', 'city.region_id')
                ->leftjoin('users', 'users.id', '=', 'posts.user_id')
                ->leftjoin('user_status','user_status.id','=','users.status')
                ->leftjoin('ownership', 'ownership.id', '=', 'posts.ownership')
                ->leftjoin('comments','comments.post_id','=','posts.id')
                ->select(
                    'posts.*',
                    'user_status.name as userstatus', 
                    'user_status.icon as userstatusicon', 
                    'city.name as city', 
                    'regions.name as region', 
                    'regions.id as region_id', 
                    'users.username as author',
                    'ownership.abr as onsabr',
                    'ownership.name as ownership',
                    DB::raw('count('.DB::getTablePrefix().'comments.post_id) as comntcount')
                    )
                ->where('posts.created_at','>',date('Y-m-d H:i:s', time() - (60*60*24*$postKeepDays) ))
                ->groupby('posts.id');
        if(!empty($searchParams['ownership'])){
            $posts->where('posts.ownership',$searchParams['ownership']);
        }
        if(!empty($searchParams['nds'])){
            $posts->where('posts.nds',$searchParams['nds']);
        }
        if(!empty($searchParams['region'])){
            $posts->where('regions.id',$searchParams['region']);
        }
        if(!empty($searchParams['city'])){
            $posts->where('posts.city_id',$searchParams['city']);
        }
        if(!empty($searchParams['name'])){
            $posts->where('title','like','%'.$searchParams['name'].'%');
        }
        if(!empty($searchParams['price'])){
            $price = explode(',', $searchParams['price']);
            $posts->where('posts.price','>=',$price[0])->where('posts.price','<=',$price[1]);
        }
        if(!empty($searchParams['name'])){
            $posts->where('title','like','%'.$searchParams['name'].'%');
        }
        if(!empty($searchParams['license']) && is_array($searchParams['license'])){
            $licenses = $searchParams['license'];
            $licenses = array_unique($licenses);
            asort($licenses);                       
            $licenses = implode(',',$licenses);
            $posts->where('posts.licenses',$licenses);
        }
        $result = $posts->orderBy('posts.id','desc')->paginate(15)->appends($searchParams);
        return $result;
    }

	public function getPosts($table_fields,$params,$id=false){        
		$sort = $params['sort'];
    	$order = $params['order'];
    	$field = $params['field'];
    	$search = $params['search'];
    	$sort_by = isset($table_fields[$sort])?$table_fields[$sort]:'posts.id';  //set default sort
    	isset($table_fields[$field])?$search_field=$table_fields[$field]:$search_field='posts.id';
        $postKeepDays = Settings::first()->post_keep_account; 

    	$posts =  DB::table('posts')
    					->leftjoin('city', 'city.id', '=', 'posts.city_id')
    					->leftjoin('regions', 'regions.id', '=', 'city.region_id')
                        ->leftjoin('ownership', 'ownership.id', '=', 'posts.ownership')  
                        ->leftjoin('users', 'users.id', '=', 'posts.user_id')                 
    					->select('posts.*', 'city.name as city', 'regions.name as region','ownership.abr as ownership','users.username')                        
    					->where($search_field,'like','%'.$search.'%')
    					->orderBy($sort_by,$order);
        if(!empty($id)){
            $posts = $posts->where('posts.user_id',$id);
        }
        if(Auth::User()->role_id!=1){
            $posts = $posts->where('posts.created_at','>',date('Y-m-d H:i:s', time() - (60*60*24*$postKeepDays) ));
        }

    	return $posts->paginate(20)->appends(array('sort' => $sort, 'order' => $order, 'field' =>$field, 'search' => $search));
	}

	public function getPost($id){
		$post =  DB::table('posts')
    					->leftjoin('city', 'city.id', '=', 'posts.city_id')
    					->leftjoin('regions', 'regions.id', '=', 'city.region_id')
    					->leftjoin('users', 'users.id', '=', 'posts.user_id')
                        ->leftjoin('nds', 'nds.id', '=', 'posts.nds')
                        ->leftjoin('ownership', 'ownership.id', '=', 'posts.ownership')
    					->select('posts.*', 'city.name as city', 'city.id as city_id', 'regions.name as region', 'regions.id as region_id', 'users.email', 'users.phone', 'users.address', 'users.username','ownership.name as ownershipname','nds.name as ndsname')
    					->where('posts.id',$id)
    					->first();                    
        return $post;
	}

    public function getMinMaxPrice(){
        $price['max'] =  DB::table('posts')->max('price');
        $price['min'] =  DB::table('posts')->min('price');
        return $price;
    }

}