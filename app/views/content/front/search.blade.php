@extends('containers.frontend')

@section('title') {{ 'Главная' }} @stop

@section('main')
	<!-- MAIN CONTENT
	============================= -->	
	<div id="main">
		<!-- search reasult page -->
		<div class="container search-result">
			<div class="row">
				<div class="col-md-12 section-title decor">
					Лучшие свадебные исполнители
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<article id="card">
						<figure>
							<a href="#null"><img src="/assets/img/photog.jpg" alt=""></a>
						</figure>
						<div class="user-info">
							<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
							<div class="info-cont">
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<div class="place">Москва</div>
								<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
							</div>
						</div>
						<div class="detail-info">
							<header>
								<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<span class="place">Москва</span>
								<div class="meta">
									<div class="review"><span>10</span>отзывов</div>
									<div class="orders"><span>48</span>заказов</div>
									<div class="rait"><img src="/assets/img/star.png" alt=""></div>
								</div>
							</header>
							<ul class="portfolio">
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
							</ul>
							<div class="price">
								<p>Ведущий на свадьбу <span>от 20 000</span></p>
								<p>Портрет <span>от 6 000</span></p>
								<p>Мероприятия <span>от 25 000</span></p>
								<p>Дети <span>от 5 000</span></p>
							</div>
							<a href="#null" class="btn-message">Сообщение</a>
							<a href="#null" class="btn-order">Заказать</a>
						</div>
					</article>
				</div>
				<div class="col-md-3 col-sm-6">
					<article id="card">
						<figure>
							<a href="#null"><img src="/assets/img/photog_2.jpg" alt=""></a>
						</figure>
						<div class="user-info">
							<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
							<div class="info-cont">
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<div class="place">Москва</div>
								<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
							</div>
						</div>
						<div class="detail-info">
							<header>
								<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<span class="place">Москва</span>
								<div class="meta">
									<div class="review"><span>10</span>отзывов</div>
									<div class="orders"><span>48</span>заказов</div>
									<div class="rait"><img src="/assets/img/star.png" alt=""></div>
								</div>
							</header>
							<ul class="portfolio">
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
							</ul>
							<div class="price">
								<p>Ведущий на свадьбу <span>от 20 000</span></p>
								<p>Портрет <span>от 6 000</span></p>
								<p>Мероприятия <span>от 25 000</span></p>
								<p>Дети <span>от 5 000</span></p>
							</div>
							<a href="#null" class="btn-message">Сообщение</a>
							<a href="#null" class="btn-order">Заказать</a>
						</div>
					</article>
				</div>
				<div class="col-md-3 col-sm-6">
					<article id="card">
						<figure>
							<a href="#null"><img src="/assets/img/photog_3.jpg" alt=""></a>
						</figure>
						<div class="user-info">
							<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
							<div class="info-cont">
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<div class="place">Москва</div>
								<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
							</div>
						</div>
						<div class="detail-info">
							<header>
								<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<span class="place">Москва</span>
								<div class="meta">
									<div class="review"><span>10</span>отзывов</div>
									<div class="orders"><span>48</span>заказов</div>
									<div class="rait"><img src="/assets/img/star.png" alt=""></div>
								</div>
							</header>
							<ul class="portfolio">
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
							</ul>
							<div class="price">
								<p>Ведущий на свадьбу <span>от 20 000</span></p>
								<p>Портрет <span>от 6 000</span></p>
								<p>Мероприятия <span>от 25 000</span></p>
								<p>Дети <span>от 5 000</span></p>
							</div>
							<a href="#null" class="btn-message">Сообщение</a>
							<a href="#null" class="btn-order">Заказать</a>
						</div>
					</article>
				</div>
				<div class="col-md-3 col-sm-6">
					<article id="card">
						<figure>
							<a href="#null"><img src="/assets/img/photog_4.jpg" alt=""></a>
						</figure>
						<div class="user-info">
							<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
							<div class="info-cont">
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<div class="place">Москва</div>
								<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
							</div>
						</div>
						<div class="detail-info">
							<header>
								<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<span class="place">Москва</span>
								<div class="meta">
									<div class="review"><span>10</span>отзывов</div>
									<div class="orders"><span>48</span>заказов</div>
									<div class="rait"><img src="/assets/img/star.png" alt=""></div>
								</div>
							</header>
							<ul class="portfolio">
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
							</ul>
							<div class="price">
								<p>Ведущий на свадьбу <span>от 20 000</span></p>
								<p>Портрет <span>от 6 000</span></p>
								<p>Мероприятия <span>от 25 000</span></p>
								<p>Дети <span>от 5 000</span></p>
							</div>
							<a href="#null" class="btn-message">Сообщение</a>
							<a href="#null" class="btn-order">Заказать</a>
						</div>
					</article>
				</div>
				<div class="col-md-3 col-sm-6">
					<article id="card">
						<figure>
							<a href="#null"><img src="/assets/img/photog.jpg" alt=""></a>
						</figure>
						<div class="user-info">
							<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
							<div class="info-cont">
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<div class="place">Москва</div>
								<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
							</div>
						</div>
						<div class="detail-info">
							<header>
								<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<span class="place">Москва</span>
								<div class="meta">
									<div class="review"><span>10</span>отзывов</div>
									<div class="orders"><span>48</span>заказов</div>
									<div class="rait"><img src="/assets/img/star.png" alt=""></div>
								</div>
							</header>
							<ul class="portfolio">
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
							</ul>
							<div class="price">
								<p>Ведущий на свадьбу <span>от 20 000</span></p>
								<p>Портрет <span>от 6 000</span></p>
								<p>Мероприятия <span>от 25 000</span></p>
								<p>Дети <span>от 5 000</span></p>
							</div>
							<a href="#null" class="btn-message">Сообщение</a>
							<a href="#null" class="btn-order">Заказать</a>
						</div>
					</article>
				</div>
				<div class="col-md-3 col-sm-6">
					<article id="card">
						<figure>
							<a href="#null"><img src="/assets/img/photog.jpg" alt=""></a>
						</figure>
						<div class="user-info">
							<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
							<div class="info-cont">
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<div class="place">Москва</div>
								<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
							</div>
						</div>
						<div class="detail-info">
							<header>
								<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>								<span class="place">Москва</span>
								<div class="meta">
									<div class="review"><span>10</span>отзывов</div>
									<div class="orders"><span>48</span>заказов</div>
									<div class="rait"><img src="/assets/img/star.png" alt=""></div>
								</div>
							</header>
							<ul class="portfolio">
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
							</ul>
							<div class="price">
								<p>Ведущий на свадьбу <span>от 20 000</span></p>
								<p>Портрет <span>от 6 000</span></p>
								<p>Мероприятия <span>от 25 000</span></p>
								<p>Дети <span>от 5 000</span></p>
							</div>
							<a href="#null" class="btn-message">Сообщение</a>
							<a href="#null" class="btn-order">Заказать</a>
						</div>
					</article>
				</div>
				<div class="col-md-3 col-sm-6">
					<article id="card">
						<figure>
							<a href="#null"><img src="/assets/img/photog.jpg" alt=""></a>
						</figure>
						<div class="user-info">
							<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
							<div class="info-cont">
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<div class="place">Москва</div>
								<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
							</div>
						</div>
						<div class="detail-info">
							<header>
								<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<span class="place">Москва</span>
								<div class="meta">
									<div class="review"><span>10</span>отзывов</div>
									<div class="orders"><span>48</span>заказов</div>
									<div class="rait"><img src="/assets/img/star.png" alt=""></div>
								</div>
							</header>
							<ul class="portfolio">
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
							</ul>
							<div class="price">
								<p>Ведущий на свадьбу <span>от 20 000</span></p>
								<p>Портрет <span>от 6 000</span></p>
								<p>Мероприятия <span>от 25 000</span></p>
								<p>Дети <span>от 5 000</span></p>
							</div>
							<a href="#null" class="btn-message">Сообщение</a>
							<a href="#null" class="btn-order">Заказать</a>
						</div>
					</article>
				</div>
				<div class="col-md-3 col-sm-6">
					<article id="card">
						<figure>
							<a href="#null"><img src="/assets/img/photog.jpg" alt=""></a>
						</figure>
						<div class="user-info">
							<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
							<div class="info-cont">
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<div class="place">Москва</div>
								<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
							</div>
						</div>
						<div class="detail-info">
							<header>
								<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
								<div class="name">
									<a href="#null">Сергей Боровой</a>
									<span class="online"></span>
									<span class="status">PRO</span>
								</div>
								<span class="place">Москва</span>
								<div class="meta">
									<div class="review"><span>10</span>отзывов</div>
									<div class="orders"><span>48</span>заказов</div>
									<div class="rait"><img src="/assets/img/star.png" alt=""></div>
								</div>
							</header>
							<ul class="portfolio">
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
								<li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
							</ul>
							<div class="price">
								<p>Ведущий на свадьбу <span>от 20 000</span></p>
								<p>Портрет <span>от 6 000</span></p>
								<p>Мероприятия <span>от 25 000</span></p>
								<p>Дети <span>от 5 000</span></p>
							</div>
							<a href="#null" class="btn-message">Сообщение</a>
							<a href="#null" class="btn-order">Заказать</a>
						</div>
					</article>
				</div>
			</div>
		</div>
	</div>
@stop