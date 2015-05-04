@extends('containers.frontend')

@section('title') {{ 'Аккаунт' }} @stop

@section('main')
<!-- MAIN CONTENT
	============================= -->	
	<div id="user-page">
		<div class="container">
			@include('content.front.account.menu_one')
			<div class="row">
				<div class="col-sm-12">
					<form class="account">
						<div class="form-group">
							<label for="old-pass">Старый пароль</label>
							<input type="text" class="form-control" id="old-pass">
						</div>
						<div class="form-group">
							<label for="new-pass">Новый пароль</label>
							<input type="text" class="form-control" id="new-pass">
						</div>
						<div class="form-group">
							<label for="pass-conf">Подтвердите</label>
							<input type="text" class="form-control" id="pass-conf">
						</div>
						<div class="form-group chbox">
							<label for="">Рассылка</label>
							<div class="cbeckbox-body">
								<div class="checkbox">
								    <input type="checkbox" id="checkbox1">
								    <label for="checkbox1">
								        Рассылка администрации
								    </label>
								</div>
								<div class="checkbox">
								    <input type="checkbox" id="checkbox2">
								    <label for="checkbox2">
								        Подписка на комментарии к постам в блоге
								    </label>
								</div>
								<div class="checkbox">
								    <input type="checkbox" id="checkbox3">
								    <label for="checkbox3">
								        Личные сообщения
								    </label>
								</div>
								<div class="pro-box">
									<div class="checkbox">
									    <input type="checkbox" id="checkbox4">
									    <label for="checkbox4">
									        Рассылка новых подходящих проектов под вашу специализацию
									    </label>
									    <span>Только для <div class="status">PRO</div></span>
									</div>
								</div>	
							</div>	
						</div>
						<a href="#null" class="btn-main">Сохранить</a>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop	