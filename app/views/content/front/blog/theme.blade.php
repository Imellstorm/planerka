@extends('containers.frontend')

@section('title') {{ $theme->name }} @stop

@section('styles')
	<style type="text/css">
		.dz-default.dz-message{
			margin: 20px 0 0 0;
			background: #ebebeb;
			padding: 20px;
			display:none;
		}
		.dz-message:after{
			content:'\a Поддерживыемые расширения: Jpeg, Jpg, Png';
		}
	</style>
@stop

@section('scripts')
	<script type="text/javascript" src="/assets/js/dropzone.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.toggle_comment_form').on('click',function(){
			$('.blog_comment_form').toggle();
		})

		$('.btn-photo').on('click',function(){
			$('.dz-default.dz-message').toggle();
		})

		Dropzone.autoDiscover = false;
		var myDropzone = new Dropzone(".dropzone", { 
			url: "/image/uploadpostimage",
			acceptedFiles: ".png, .jpg, .jpeg",
			autoProcessQueue: false,
			addRemoveLinks: 'dictCancelUpload',
			dictDefaultMessage: 'Перетащите фотографии сюда или <span class="file-wrap">Загрузите с компьютера</span>'
		})

		myDropzone.on('addedfile',function(file,message){
			$('.dz-upload').fadeOut('normal');	
		})

		// myDropzone.on('removedfile',function(file,message){
		// 	if(myDropzone.getQueuedFiles().length==0){
		// 		$('.upload_process').hide();
		// 	}
		// })

		myDropzone.on('error',function(file,message){
			$('.dz-upload').fadeOut('normal');
			$('.loading').hide();
			$('.upload_process').hide();
			$(file.previewElement).find('.dz-error-mark').show();
			uploadErr = 1;
				
		})

		myDropzone.on('success',function(file,message){
			$(file.previewElement).find('.dz-success-mark').show();
		})

		myDropzone.on('queuecomplete',function(file,message){
			this.options.autoProcessQueue = false
			$('.post_submit').show();
			$('.loading').hide();
			
			// if(uploadErr!=1){
			// 	window.location.href = document.URL;
			// }
		})

		myDropzone.on('complete',function(file,message){
			window.location.href = document.URL;
		})

		myDropzone.on('processing',function(file,message){
			$('.post_submit').hide();
			$('.loading').show();
			this.options.autoProcessQueue = true
		})

		$('.post_submit').on('click',function(){
			uploadErr = 0;
			var text = $('.post_text').val();
			if(text.length){
				$.ajax({
					url:'/blog/savepost',
					type:'post',
					data:{
						text: $('.post_text').val(),
						theme_id: $('.theme_id').val() 
					},
					success:function(res){
						if(res.length){
							$('.post_id').val(res);
							// $.when(myDropzone.processQueue()).then(function(){
							// 	window.location.href = document.URL
							// })
						}
					}
				})
			} else {
				$('.post_text').attr('placeholder','Вы не можете отправить пустое сообщение');
			}
		})
	})
	</script>
@stop

@section('main')
	<div id="blog">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-title decor">
					{{ $theme->name }}
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<ul class="inner-nav">
						<li><a href="/blog">{{ $category->name }}</a></li>
						<li><a href="/blog/category/{{ $subcategory->id }}">{{ $subcategory->name }}</a></li>
						<li><a class="active">{{ $theme->name }}</a></li>
					</ul>
				</div>
			</div>

			{{ $posts->links() }}

			<div class="row">
				<div class="col-sm-12">
					@if(count($posts))
						@foreach($posts as $post)
							<div class="single-blog" style="position:relative">
								<footer>
									<div class="user-info">
										<a href="/{{ $post->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($post->user_id) }}" alt=""></a>
										<div class="name">
											@if(!empty($post->user_name) || !empty($post->surname))
												<a href="/{{ $post->alias }}">{{ $post->user_name }} {{ $post->surname }}</a>
											@else
												<a href="/{{ $post->alias }}">{{ $post->alias }}</a>
											@endif
											<span class="{{ $post->online?'online':'offline' }}"></span>
											@if($post->pro)
												<span class="status">PRO</span>
											@endif
										</div>
										<span class="place">{{ $post->city }}</span>
									</div>
									<ul class="meta">
										<li>Опубликовано: <span>{{ $post->created_at }}</span></li>
									</ul>
								</footer>
								<p style="margin-top:20px">{{ $post->text }}</p>
								@if(count($post->images))
									@foreach($post->images as $image)
										<img src="/{{ $image->thumb }}" style="margin-top:3px">
									@endforeach
								@endif
								@if(Auth::check() && (Auth::user()->id==$post->user_id || Auth::user()->role_id==1))
									<a href="/blog/deletepost/{{ $post->id }}" class="fa fa-times delete-image"></a>
								@endif
							</div>
						@endforeach
					@endif
				</div>
				@if(Auth::check())
					<div class="col-sm-12">
						<div class="btn-main pull-right toggle_comment_form" style="cursor:pointer;margin-bottom:20px;">Ответить</div>
					</div>
					<div class="col-sm-12 blog_comment_form" style="display:none">
						<div style="display:block">
							{{ Form::open(array('role' => 'form', 'url' => '/blog/storepost', 'method' => 'post', 'class'=>'blog-msg dropzone', 'style'=>'overflow:initial;margin-top:200px;padding:0;background:none;')) }}
								<div style="overflow:hidden; margin-top:-200px;">
									<div class="form-group">
										<textarea id="text" name="text" class="form-control post_text" required placeholder="Текст сообщения" style="max-width:100%;"></textarea>
									</div>
									<div class="btn-photo" style="float:left;margin: 0 20px 0 0;">Добавить фото</div>
									<input type="hidden" name="theme_id" class="theme_id" value="{{ $theme->id }}">
									<input type="hidden" name="post_id" class="post_id">
								</div>

								<div class="fallback">
									<input name="file" type="file" multiple />
								</div>
								<div class="btn-main post_submit" style="display:block;float:right;margin-top:-37px;cursor:pointer;">ПРОДОЛЖИТЬ</div>
								<img src="/assets/img/loading.gif" class="loading" style="display:none;float:right;margin: -40px 50px 0 0;">
							{{ Form::close() }}
						</div>
					</div>		
				@endif
			</div>

			{{ $posts->links() }}

		</div>
	</div>	
@stop