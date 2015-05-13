@extends('containers.frontend')

@section('title') {{ 'Профиль|календарь' }} @stop

@section('main')
	<div id="user-page">
		<div class="container">
			@include('content.front.profile.menu')
			<div class="row">
				<div class="col-sm-12">
					<div class="clndr-msg">
						Используйте календарь - это позволит вам занимать первые места в поисковой выдаче. Отметье день как занятый, кликнув на требуемую дату. Планёрка не будет отправлять вам заказы на это число. Заказы принятые через наш сервис автоматически проставляются в календарь
					</div>
					<div class="calendar">
						<div class="datepicker"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12" style="color:#ec7575; font-size: 20px;;">
					Для зарезервированой даты нужно добавть класс .reserved
				</div>
			</div>
		</div>
	</div>	
@stop