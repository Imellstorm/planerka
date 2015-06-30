@extends('containers.frontend')

@section('title') {{ 'Альбом '.$album->name }} @stop

@section('main')
<div id="album">
	<div class="container">
		<div class="row photos">
			@if(!empty($images))
				<?php $imgCount = count($images); ?>
				<div class="col-md-6 col-md-offset-3 text-center">
					@foreach($images as $key=>$image)
						<?php //list($width,$height) = getimagesize(base_path().'/public/'.$image->thumb_big) ?>
						<div class="img-wrapp">
							<a href="/{{ $image->path }}" rel="gallery1" class="fancybox" >
								<img src="/{{ $image->thumb_big }}" alt="">
							</a>
							@if(Auth::check() && Auth::user()->id==$image->user_id)
								<a href="/image/delete/{{ $image->id }}" class="fa fa-times delete-image" onclick="return confirm('Удалить?')?true:false;"></a>
							@endif
							<div class="cont-box">
								@if(Auth::check())
									<div class="like" imageid="{{ $image->id }}">
										Нравиться: <span class="likes-count">{{ $image->likes?$image->likes:'0' }}</span>
									</div>
								@endif
								@if(Auth::check() && Auth::user()->id==$image->user_id)
									<div class="set">
										<h4>Установить</h4>
										<a href="/album/setalbumcover/{{ $album->id.'/'.$image->id }}" class="hover_green">обложкой альбома</a>
										<a href="/album/setprofilecover/{{ $image->id }}" class="hover_green">баннером профиля</a>
									</div>
								@endif
								<div class="share">
									<h4>Поделиться</h4>
									<a class="vk" onclick="Share.vkontakte('{{ URL::current() }}','Авторское фото','{{ URL::to('/').'/'.$image->thumb_small }}','{{ $userInfo->name.' '.$userInfo->surname }}')"></a>
									<a class="facebook" onclick="Share.facebook('{{ URL::current() }}','Авторское фото','{{ URL::to('/').'/'.$image->thumb_small }}','{{ $userInfo->name.' '.$userInfo->surname }}')"></a>
									<a class="twitter" onclick="Share.twitter('{{ URL::current() }}','Авторское фото {{ $userInfo->name.' '.$userInfo->surname }}')"></a>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@endif
		</div>
		<div class="row">
			<div class="col-sm-12 album-footer">
				<div class="user-info">
					<a href="#null" class="avatar">
						<img src="{{ Common_helper::getUserAvatar($user->id) }}" alt="">
					</a>
					<div class="name">
						<a href="#null">{{ $userInfo->name.' '.$userInfo->surname }}</a>
						<span class="{{ $user->online?'online':'offline' }}"></span>
						<span class="status">PRO</span>
					</div>
					<span class="place">{{ $userInfo->city }}</span>
					<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
				</div>				
				<div class="user-btns">
					<a href="/{{ $user->alias }}" class="btn-gray">Обратно в профиль</a>
					@if(Auth::check() && Auth::user()->id!=$user->id)
						<a href="/message/create/{{ $user->id }}" class="btn-purple fancybox_ajax_scroll">Написать сообщение</a>
					@endif
				</div>				
				@if(Auth::check() && Auth::user()->id==$user->id)
					<div class="album-btns">
						<a href="#upload-photo" class="fancybox add_photo">Добавить Фото</a>
						<a href="/album/delete/{{ $album->id }}" class="del_album" onclick="return confirm('Удалить альбом?')?true:false;">Удалить Альбом</a>
					</div>
				@endif
			</div>
		</div>
		<div class="custom-modal" id="upload-photo">
			<div class="title">Загрузить фотографии</div>
			<div style="background:#ebebeb;padding:40px;">
				<form action="/image/uploadimage" class="dropzone">
					<div class="fallback">
						<input name="file" type="file" multiple />
					</div>
				</form>
				<div style="color:#a8a8a8;clear:both;">
					<p>Не менее 600px по большей стороне. Оптимельное 2400px
					<br>Поддерживыемые расширения: Jpeg, Jpg, Png</p>
				</div>
			</div>
			<footer style="clear:both">
				<p>Ваш лимит: <span>20 фото в неделю</span></p>
				<p>Купите аккаунт <span class="status"><a href="#null">PRO</a></span>чтобы загружать фотографии без ограничения</p>
			</footer>
			<div style="margin-top:20px">
				<div class="btn-main upload_process" style="margin:0 auto">ПРОДОЛЖИТЬ</div>
				<img src="/assets/img/loading.gif" class="loading" style="display:none">
			</div>						
		</div>
	</div>
</div>	
@stop

@section('scripts')
<script type="text/javascript" src="/assets/js/dropzone.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		@if(isset($new) && !empty($new))
			$(".add_photo").fancybox().trigger('click');
		@endif

		Dropzone.autoDiscover = false;
		var myDropzone = new Dropzone(".dropzone", { 
			url: "/image/uploadimage/{{ $album->id }}",
			acceptedFiles: ".png, .jpg, .jpeg",
			autoProcessQueue: false,
			addRemoveLinks: 'dictCancelUpload',
			dictDefaultMessage: 'Перетащите фотографии сюда или <span class="file-wrap">Загрузите с компьютера</span>'
		})

		myDropzone.on('addedfile',function(file,message){
			$('.dz-upload').fadeOut('normal');
			$.fancybox.update();	
		})

		myDropzone.on('error',function(file,message){
			$('.dz-upload').fadeOut('normal');
			$('.loading').hide();
			$('.upload_process').show();
			$.fancybox.update();	
		})

		myDropzone.on('success',function(file,message){
			window.location.href = document.URL;
		})

		$('.upload_process').on('click',function(){
			$(this).hide();
			$('.loading').show();
			myDropzone.processQueue();
		})

		$('.like').on('click',function(){
			elem = $(this).find('.likes-count');
			$.ajax({
				url: '/image/like',
				type: 'post',
				datatype: 'json',
				data: {
					imageid: $(this).attr('imageid')
				},
				success: function(ret){
					if(ret=='success'){
						elem.text(parseInt(elem.text())+1);
					} else {
						alert('Вы уже отметили эту фотографию');
					}
				}
			})
		})
	})

	Share = {
	    vkontakte: function(purl, ptitle, pimg, text) {
	        url  = 'http://vkontakte.ru/share.php?';
	        url += 'url='          + encodeURIComponent(purl);
	        url += '&title='       + encodeURIComponent(ptitle);
	        url += '&description=' + encodeURIComponent(text);
	        url += '&image='       + encodeURIComponent(pimg);
	        url += '&noparse=true';
	        Share.popup(url);
	    },
	    odnoklassniki: function(purl, text) {
	        url  = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1';
	        url += '&st.comments=' + encodeURIComponent(text);
	        url += '&st._surl='    + encodeURIComponent(purl);
	        Share.popup(url);
	    },
	    facebook: function(purl, ptitle, pimg, text) {     //удалять кэш https://developers.facebook.com/tools/debug/og/object/
	        url  = 'http://www.facebook.com/sharer.php?s=100';
	        url += '&p[title]='     + ptitle;
	        url += '&p[summary]='   + text;
	        url += '&p[url]='       + purl;
	        url += '&p[images][0]=' + pimg;
	        Share.popup(url);
	    },
	    twitter: function(purl, ptitle) {
	        url  = 'http://twitter.com/share?';
	        url += 'text='      + encodeURIComponent(ptitle);
	        url += '&url='      + encodeURIComponent(purl);
	        url += '&counturl=' + encodeURIComponent(purl);
	        Share.popup(url);
	    },
	    mailru: function(purl, ptitle, pimg, text) {
	        url  = 'http://connect.mail.ru/share?';
	        url += 'url='          + encodeURIComponent(purl);
	        url += '&title='       + encodeURIComponent(ptitle);
	        url += '&description=' + encodeURIComponent(text);
	        url += '&imageurl='    + encodeURIComponent(pimg);
	        Share.popup(url)
	    },

	    popup: function(url) {
	        window.open(url,'','toolbar=0,status=0,width=626,height=436');
	    }
	};

</script>
@stop