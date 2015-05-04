@extends('containers.frontend')

@section('title') {{ 'Специализация' }} @stop

@section('main')
<!-- MAIN CONTENT
	============================= -->	
	<div id="user-page">
		<div class="container">
			@include('content.front.account.menu_one')
			<div class="row">
				<div class="col-sm-12">
					<div class="specif">
						<div class="title">Основная специализация</div>
						<form class="specif">
							<div class="form-group">
								<select id="select-specif" class="selectpicker sel-green">
								    <option>Ведущий на свадьбу</option>
								    <option>Фотограф</option>
								    <option>Оператор</option>
								</select>
								<a href="#null" class="delate">Удалить</a>
								<div class="comment">Выберите раздел и специализацию из каталога</div>
							</div>
							<div class="form-group">
								<label for="count-service">Стоимость услуги</label>
								<input type="text" id="count-service" class="form-control">
							</div>
							<div class="form-goup">
								<label for="description">Что входит в стоимость</label>
								<textarea id="description" class="form-control"></textarea>
							</div>
						</form>
						<a href="#null" class="add-specif">Добавить другую специализацию</a>
					</div>
					<div class="specif">
						<div class="title">Дополнительная специализация</div>
						<form class="specif">
							<div class="form-group">
								<select id="select-specif" class="selectpicker sel-green">
								    <option>Ведущий на свадьбу</option>
								    <option>Фотограф</option>
								    <option>Оператор</option>
								</select>
								<a href="#null" class="delate">Удалить</a>
								<div class="comment">Выберите раздел и специализацию из каталога</div>
							</div>
							<div class="form-group">
								<label for="count-service">Стоимость услуги</label>
								<input type="text" id="count-service" class="form-control">
							</div>
							<div class="form-goup">
								<label for="description">Что входит в стоимость</label>
								<textarea id="description" class="form-control"></textarea>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>	
@stop