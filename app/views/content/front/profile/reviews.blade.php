@extends('containers.frontend')

@section('title') {{ 'Профиль|отзывы' }} @stop

@section('main')
    <div id="user-page">
		<div class="container">
			@include('content.front.profile.menu')
			<div class="row">
				<div class="col-sm-12 user-review">
					<div class="review">
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
						<div class="cont">
							<div class="date">06 ноября 2015</div>
							<p>Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода</p>
							<ul class="photo-list">
								<li>
									<img src="#" alt="">
								</li>
								<li>
									<img src="#" alt="">
								</li>
								<li>
									<img src="#" alt="">
								</li>
							</ul>
						</div>
					</div>
					<div class="review">
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
						<div class="cont">
							<div class="date">06 ноября 2015</div>
							<p>Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода</p>
							<ul class="photo-list">
								<li>
									<img src="#" alt="">
								</li>
								<li>
									<img src="#" alt="">
								</li>
								<li>
									<img src="#" alt="">
								</li>
							</ul>
						</div>
					</div>
					<div class="review">
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
						<div class="cont">
							<div class="date">06 ноября 2015</div>
							<p>Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода</p>
							<ul class="photo-list">
								<li>
									<img src="#" alt="">
								</li>
								<li>
									<img src="#" alt="">
								</li>
								<li>
									<img src="#" alt="">
								</li>
							</ul>
							<form class="rev">
								<div class="form-group">
									<textarea class="form-control"></textarea>
									<a href="#null" class="btn-main">Оставить отзыв</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
@stop