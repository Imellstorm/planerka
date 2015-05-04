@extends('containers.frontend')

@section('title') {{ 'Сообщения' }} @stop

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
							<a href="#null" class="view-all">Прочитать все сообщения</a>
							
							<div class="single-msg">
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
								<div class="msg-cont">
									<div class="time">10 минут назад</div>
									<div class="text-msg">В связи с отсутствием Сереги и Вани нужно перенести тренировку с понедельника на среду.</div>
									<a href="#null" class="reply">Ответить</a>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>	
@stop