@extends('containers.frontend')

@section('title') {{ 'Заказы' }} @stop

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
							<div class="single-order">
								<div class="user-info">
									<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
									<div class="name">
										<a href="#null">Сергей Боровой</a>
										<span class="online"></span>
										<span class="status">PRO</span>
									</div>
									<span class="place">Москва</span>
								</div>
								<div class="order-body">
									<header>
										<div class="title">Очень классный ведущий на свадьбу</div>
										<div class="price">25 000 руб.</div>
									</header>
									<div class="text">Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет</div>
									<ul class="meta-list">
										<li>Съмка: <span>22 сентября</span></li>
										<li>Город: <span>Москва</span></li>
										<li>Статус: <span>Не принят</span></li>
									</ul>
									<a href="#null" class="btn-purple">Обсудить условия</a>
									<a href="#null" class="btn-main">Принять заказ</a>
									<a href="#null" class="btn-disable">Отказаться от заказа</a>
								</div>
							</div>
							<div class="single-order">
								<div class="user-info">
									<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
									<div class="name">
										<a href="#null">Сергей Боровой</a>
										<span class="online"></span>
										<span class="status">PRO</span>
									</div>
									<span class="place">Москва</span>
								</div>
								<div class="order-body">
									<header>
										<div class="title">Очень классный ведущий на свадьбу</div>
										<div class="price">25 000 руб.</div>
									</header>
									<div class="text">Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет</div>
									<ul class="meta-list">
										<li>Съмка: <span>22 сентября</span></li>
										<li>Город: <span>Москва</span></li>
										<li>Статус: <span>Не принят</span></li>
									</ul>
									<a href="#null" class="btn-purple">Обсудить условия</a>
									<a href="#null" class="btn-main">Принять заказ</a>
									<a href="#null" class="btn-disable">Отказаться от заказа</a>
								</div>
							</div>
							<div class="single-order">
								<div class="user-info">
									<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
									<div class="name">
										<a href="#null">Сергей Боровой</a>
										<span class="online"></span>
										<span class="status">PRO</span>
									</div>
									<span class="place">Москва</span>
								</div>
								<div class="order-body">
									<header>
										<div class="title">Очень классный ведущий на свадьбу</div>
										<div class="price">25 000 руб.</div>
									</header>
									<div class="text">Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет</div>
									<ul class="meta-list">
										<li>Съмка: <span>22 сентября</span></li>
										<li>Город: <span>Москва</span></li>
										<li>Статус: <span>Не принят</span></li>
									</ul>
									<a href="#null" class="btn-purple">Обсудить условия</a>
									<a href="#null" class="btn-main">Принять заказ</a>
									<a href="#null" class="btn-disable">Отказаться от заказа</a>
								</div>
							</div>
							<div class="single-order">
								<div class="user-info">
									<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
									<div class="name">
										<a href="#null">Сергей Боровой</a>
										<span class="online"></span>
										<span class="status">PRO</span>
									</div>
									<span class="place">Москва</span>
								</div>
								<div class="order-body">
									<header>
										<div class="title">Очень классный ведущий на свадьбу</div>
										<div class="price">25 000 руб.</div>
									</header>
									<div class="text">Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет Мы рассматриваем ведущих с опытом от 3х лет</div>
									<ul class="meta-list">
										<li>Съмка: <span>22 сентября</span></li>
										<li>Город: <span>Москва</span></li>
										<li>Статус: <span>Не принят</span></li>
									</ul>
									<a href="#null" class="btn-purple">Обсудить условия</a>
									<a href="#null" class="btn-main">Принять заказ</a>
									<a href="#null" class="btn-disable">Отказаться от заказа</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>	
@stop