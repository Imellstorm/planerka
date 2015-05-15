@extends('containers.frontend')

@section('title') {{ 'Профиль|фото' }} @stop

@section('main')

<div id="album">
	<div class="container">
		<div class="row photos">
			@if(!empty($images))
				<?php $imgCount = count($images); ?>
				<div class="col-md-7">
					@foreach($images as $key=>$image)
						@if($key>=$imgCount/2)
							</div>
							<div class="col-md-5">
						@endif
						<div class="img-wrapp">
							<a href="#null">
								<img src="/{{ $image->thumb_big }}" alt="">
							</a>
							<a href="/image/delete/{{ $image->id }}" class="fa fa-times delete-image"></a>
							<div class="cont-box">
								<div class="like">
									Нравиться: 15
								</div>
								<div class="set">
									<h4>Установить</h4>
									<a href="/album/setalbumcover/{{ $album->id.'/'.$image->id }}">обложкой альбома</a>
									<a href="#null">баннером профиля</a>
								</div>
								<div class="share">
									<h4>Поделиться</h4>
									<a href="#null" class="facebook"></a>
									<a href="#null" class="vk"></a>
									<a href="#null" class="twitter"></a>
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
						<a href="#null">{{ $userinfo->name.' '.$userinfo->surname }}</a>
						<span class="online"></span>
						<span class="status">PRO</span>
					</div>
					<span class="place">{{ $userinfo->city }}</span>
					<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
				</div>
				<div class="user-btns">
					<a href="/{{ $user->alias }}/photo" class="btn-gray">Обратно в профиль</a>
					<a href="#null" class="btn-purple">Написать сообщение</a>
				</div>
				<div class="album-btns">
					<a href="#upload-photo" class="fancybox add_photo">Добавить Фото</a>
					<a href="/album/delete/{{ $album->id }}" class="del_album" onclick="return confirm('Удалить альбом?')?true:false;">Удалить Альбом</a>
				</div>
			</div>
		</div>
		<div class="custom-modal" id="upload-photo">
			<div class="title">Загрузить фотографии</div>
			<form action="/album/uploadimage" class="dropzone">
			  <div class="fallback">
			    <input name="file" type="file" multiple />
			  </div>
			</form>
			<footer style="clear:both">
				<p style="font-size:12px">Не менее 600px по большей стороне. Оптимельное 2400px
				<br>Поддерживыемые расширения: Jpeg, Jpg, Png</p>
				<p>Ваш лимит: <span>20 фото в неделю</span></p>
				<p>Купите аккаунт <span class="status"><a href="#null">PRO</a></span>чтобы загружать фотографии без ограничения</p>
			</footer>						
		</div>
	</div>
</div>	
@stop

@section('scripts')
<script type="text/javascript" src="/assets/js/dropzone.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		Dropzone.autoDiscover = false;
		var myDropzone = new Dropzone(".dropzone", { 
			url: "/album/uploadimage/{{ $album->id }}",
			acceptedFiles: ".png, .jpg, .jpeg",
			dictDefaultMessage: 'Перетащите картинки в эту область'
		});
		myDropzone.on('success',function(file,message){
			$('.dz-upload').fadeOut('normal');
			$.fancybox.update();	
		})
		myDropzone.on('error',function(file,message){
			$('.dz-upload').fadeOut('normal');
			$.fancybox.update();	
		})
	})

</script>
@stop