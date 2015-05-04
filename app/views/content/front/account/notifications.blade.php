@extends('containers.frontend')

@section('title') {{ 'Уведомления' }} @stop

@section('main')
	<!-- MAIN CONTENT
	============================= -->	
	<div id="main">
		<!-- admin massage -->
		<div class="notification">
			<div class="container">
				@include('content.front.account.menu_two')
				<div class="row">
					<div class="col-sm-12">
						<div class="notif-content">							
							<div class="single-notif">
								<div class="user-info">
									<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
									<div class="name">
										<a href="#null">Сергей Боровой</a>
										<span class="online"></span>
										<span class="status">PRO</span>
									</div>
									<span class="place">Москва</span>
									<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
								</div>
								<div class="notif-text">
									<span class="photo-like">Оценила вашу фотографию <a href="#null"><img src="/assets/img/photo_like.jpg" alt=""></a></span>
								</div>
								<div class="notif-time">
									23 минуты назад
								</div>
							</div>
							<div class="single-notif">
								<div class="user-info">
									<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
									<div class="name">
										<a href="#null">Сергей Боровой</a>
										<span class="online"></span>
										<span class="status">PRO</span>
									</div>
									<span class="place">Москва</span>
									<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
								</div>
								<div class="notif-text">
									<p>Ответила на ваш комментарий к посту «Выбор платья»</p>
								</div>
								<div class="notif-time">
									23 минуты назад
								</div>
							</div>
							<div class="single-notif">
								<div class="user-info">
									<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
									<div class="name">
										<a href="#null">Сергей Боровой</a>
										<span class="online"></span>
										<span class="status">PRO</span>
									</div>
									<span class="place">Москва</span>
									<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
								</div>
								<div class="notif-text">
									<span class="photo-like">Оценила вашу фотографию <a href="#null"><img src="/assets/img/photo_like.jpg" alt=""></a></span>
								</div>
								<div class="notif-time">
									23 минуты назад
								</div>
							</div>
							<div class="single-notif">
								<div class="user-info">
									<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
									<div class="name">
										<a href="#null">Сергей Боровой</a>
										<span class="online"></span>
										<span class="status">PRO</span>
									</div>
									<span class="place">Москва</span>
									<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
								</div>
								<div class="notif-text">
									<p>Ответила на ваш комментарий к посту «Выбор платья»</p>
								</div>
								<div class="notif-time">
									23 минуты назад
								</div>
							</div>		
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>	
@stop