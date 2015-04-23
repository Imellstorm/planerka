<?php

class postController extends BaseController {

	protected $rules = array(
		'title'		=> 'required|max:128',
		'ownership'	=> 'required|max:8|not_in:0',
		'region'	=> 'required|not_in:0',		
		'price'		=> 'required|numeric',
		'license'	=> 'max:256',
	);
	protected $table_fields = array(
			'Название'				=> 'title',
			'форма собственности'	=> 'ownership.abr',	
			'Цена'					=> 'price',	
			'Автор'					=> 'users.username',
			'Населённый пункт'		=> 'city.name',
			'Опубликовано'			=> 'created_at',
		);	

	/**
	* Display a listing of posts
	*
	* @return Response
	*/
	public function getIndex()
	{
		$model = new Post;
		$params = array(
			'sort' 		=> Input::get('sort'),
	    	'order' 	=> Input::get('order'),
	    	'field' 	=> Input::get('field'),
	    	'search' 	=> Input::get('search'),
    	);
		$table_fields = $this->table_fields;

        $posts = $model->getposts($table_fields,$params);      
        $ownership = Config::get('site_config.ownership');

		return View::make('content.admin.posts.index', compact('posts','table_fields','ownership'));
	}

	/**
	 * Show the form for creating a new post
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		$regions = Region::lists('name','id');
		$regions[0] = 'Выберите область';
		ksort($regions);

		$ownership = Ownership::lists('abr','id');
		$ownership[0] = 'Выберите форму собственности';
		ksort($ownership);

		$nds = Nds::lists('abr','id');
		$nds[0] = 'Выберите форму налогообложения';
		ksort($nds);

		$license = License::lists('abr','id');

		return View::make('content.admin.posts.form',compact('regions','ownership','nds','license'));
	}


	/**
	 * Store a newly created post in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{		
		$validator = Validator::make(Input::all(), $this->rules);		

		if ($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			$post = new Post;

			/***Files upload***/
			$files = Input::file('files');
			if($files[0]!=null){
				$post->files = $this->uploadFiles($files);
			}
			/*****************/			
 
	        $post->title   		= Input::get('title');
	        $post->ownership    = Input::get('ownership');
	        $post->price    	= Input::get('price');
	        $post->city_id    	= Input::get('city');
	        $post->nds    		= Input::get('nds');
	        $post->user_id    	= Auth::User()->id;	          
	        $post->description 	= Input::get('description')?Input::get('description'):'';

	        $licenses = Input::get('license');
	        if(!empty($licenses) && is_array($licenses)){
	        	$licenses = array_unique($licenses);
	        	asort($licenses);				     	
	        	$post->licenses = implode(',',$licenses);
	        }

        	$res = $post->save();       	
		}

		Session::flash('success', 'Объявение создано!');
		if($this->is_admin()){
			return Redirect::to('/admin/posts');
		} else {
			return Redirect::to('/account/posts');
		}
	}

	/**
	 * Store uploaded files
	 *
	 * @return Json
	 */
	private function uploadFiles($files,$existFiles=array()){
		$fileUploadErrors = array();
		$fileUploaded = array();

		foreach ($files as $file) {
			if(!empty($file)){

				$validator = Validator::make(
			        array(
			            'attachment' => $file,
			            'extension'  => \Str::lower($file->getClientOriginalExtension()),
			        ),
			        array(
			            'attachment' => 'required|max:1000',
			            'extension'  => 'required|in:jpg,jpeg,bmp,png,gif,doc,docx,pdf,rtf,xlsx,xls,txt',
			        )
			    ); 
				if($validator->fails()){
					return Redirect::back()->withErrors($validator)->withInput();
				}
				$destinationPath = 'uploads/'.Auth::User()->email.'/';
				if(!is_dir($destinationPath)){
					File::makeDirectory($destinationPath , 0775, true);
				}
				$filename = $file->getClientOriginalName();				
				$uploadSuccess = $file->move($destinationPath, $filename);
				if($uploadSuccess) {
					 $fileUploaded[$filename] = $destinationPath.$filename;
				} else {
					$fileUploadErrors[]=$filename;
				}
			}
		}
		if(isset($fileUploadErrors[0])){
			return Redirect::back()->withErrors('Следующие файлы не были загружены'.implode(', ', $fileUploadErrors))->withInput();
		}
		if(is_array($existFiles)){
			$fileUploaded = array_merge($existFiles,$fileUploaded);
		}
 		return json_encode($fileUploaded);	
	}


	/**
	 * Show the form for editing the specified post.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$model = new Post;
		$post = $model->getPost($id);

		if(!empty($post)){
			$regions = Region::lists('name','id');
			$regions[0] = 'Выберите область';
			ksort($regions);

			$ownership = Ownership::lists('abr','id');
			$ownership[0] = 'Выберите форму собственности';
			ksort($ownership);

			$nds = Nds::lists('abr','id');
			$nds[0] = 'Выберите форму налогообложения';
			ksort($nds);

			$license = License::lists('abr','id');

			return View::make('content.admin.posts.form', compact('post','regions','ownership','nds','license'));
		} else {
			App::abort(404);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function putUpdate($id)
	{
		$post = Post::find($id);
		if(empty($post)){
			App::abort(404);
		}

		if(!$this->is_owner($post->user_id)){
			return Redirect::to('/')->withErrors('У вас недостаточно прав!');
		}
		
		$validator = Validator::make($data = Input::all(), $this->rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			
			$data = array(
		        'title'			=> Input::get('title'),
		        'ownership'		=> Input::get('ownership'),		        
		        'price' 	 	=> Input::get('price'),
		        'city_id' 	 	=> Input::get('city'),
		        'nds'			=> Input::get('nds'),	        
		        'description' 	=> Input::get('description')?Input::get('description'):'',		        
	        );

			$licenses = Input::get('license');
	        if(!empty($licenses) && is_array($licenses)){
	        	$licenses = array_unique($licenses);
	        	asort($licenses);				     	
	        	$data['licenses'] = implode(',',$licenses);
	        }

			$files = Input::file('files');
			$existFiles = Input::get('existFiles');
			if($files[0]!=null){
				$data['files'] = $this->uploadFiles($files,$existFiles);
			} else {
				if(!empty($existFiles)){
					$data['files'] = json_encode($existFiles);
				} else {
					$data['files'] = '';
				}
			}

        	$post->update($data);        	
		}
		Session::flash('success', 'Объявление обновлено!');

		if($this->is_admin()){
			return Redirect::to('admin/posts');
		} else {
			return Redirect::to('account/posts');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteDestroy($id)
	{
		$post = Post::find($id);
		if(empty($post)){
			App::abort(404);
		}
		if(!$this->is_owner($post->user_id)){
			return Redirect::to('/')->withErrors('У вас недостаточно прав!');
		}
		Post::destroy($id);
		Vippost::where('post_id',$id)->delete();
		Comment::where('post_id',$id)->delete();
		Session::flash('success', 'Объявление удалёно!');
		return Redirect::back();
	}

}

