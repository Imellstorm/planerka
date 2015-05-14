@extends('containers.frontend')

@section('title') {{ 'Профиль|фото' }} @stop

@section('main')

<div id="album">
	<div class="container">
		<div class="row photos">
			<div class="col-md-7">
				<div class="img-wrapp">
					<a href="#null"><img src="/assets/img/album/01.jpg" alt=""></a>
					<div class="cont-box">
						<div class="like">
							Нравиться: 15
						</div>
						<div class="set">
							<h4>Установить</h4>
							<a href="#null">обложкой альбома</a>
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
				<div class="img-wrapp">
					<a href="#null"><img src="/assets/img/album/05.jpg" alt=""></a>
					<div class="cont-box">
						<div class="like">
							Нравиться: 15
						</div>
						<div class="set">
							<h4>Установить</h4>
							<a href="#null">обложкой альбома</a>
							<a href="#null">бфаннером профиля</a>
						</div>
						<div class="share">
							<h4>Поделиться</h4>
							<a href="#null" class="facebook"></a>
							<a href="#null" class="vk"></a>
							<a href="#null" class="twitter"></a>
						</div>
					</div>
				</div>	
			</div>
			<div class="col-md-5">
				<div class="img-wrapp">
					<a href="#null"><img src="/assets/img/album/03.jpg" alt=""></a>
					<div class="cont-box">
						<div class="like">
							Нравиться: 15
						</div>
						<div class="set">
							<h4>Установить</h4>
							<a href="#null">обложкой альбома</a>
							<a href="#null">бфаннером профиля</a>
						</div>
						<div class="share">
							<h4>Поделиться</h4>
							<a href="#null" class="facebook"></a>
							<a href="#null" class="vk"></a>
							<a href="#null" class="twitter"></a>
						</div>
					</div>
				</div>	
				<div class="img-wrapp">	
					<a href="#null"><img src="/assets/img/album/04.jpg" alt=""></a>
					<div class="cont-box">
						<div class="like">
							Нравиться: 15
						</div>
						<div class="set">
							<h4>Установить</h4>
							<a href="#null">обложкой альбома</a>
							<a href="#null">бфаннером профиля</a>
						</div>
						<div class="share">
							<h4>Поделиться</h4>
							<a href="#null" class="facebook"></a>
							<a href="#null" class="vk"></a>
							<a href="#null" class="twitter"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 album-footer">
				<div class="user-info">
					<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
					<div class="name">
						<a href="#null">{{ Auth::user()->username }}</a>
						<span class="online"></span>
						<span class="status">PRO</span>
					</div>
					<span class="place">{{ $userinfo->city }}</span>
					<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
				</div>
				<div class="user-btns">
					<a href="/{{ $useralias }}/photo" class="btn-gray">Обратно в профиль</a>
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
			url: "/album/uploadimage",
			dictDefaultMessage: 'Перетащите картинки в эту область'
		});
		myDropzone.on('success',function(file,message){
			$('.dz-success-mark').show();
			$.fancybox.update();	
		})
		myDropzone.on('error',function(file,message){
			$('.dz-error-mark').show();
			$.fancybox.update();	
		})
	})

</script>
@stop