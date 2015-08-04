@extends('containers.frontend')

@section('title') Услуги @stop

@section('main')
<!-- MAIN CONTENT
	============================= -->	
	<div id="shop">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-title decor">
					Закажите PROдвинутые услуги на ПЛАНЁРКЕ
				</div>
			</div>
			@if(Auth::user()->role_id != 2)
				<a class="by-promo" style="top:-30px; cursor:pointer">
					Продлить ПРОМО-размещение на 7 дней за 239 руб.
				</a>
			@endif
			<div class="row">
				<div class="col-sm-12">
					<div class="price-tables">
						<table class="low">
							<tr>
								<th>
									<h3>Размещение<br> рекламы на сайте</h3>
									<a href="/account/places" class="add">Перейти к выбору места</a>
								</th>
							</tr>
							<tr>
								<td>
									Размещение новости или статьи
								</td>
							</tr>
							<tr>
								<td>
									Публикиция индивидуального баннера
								</td>
							</tr>
							<tr>
								<td>
									Размещение профиля в разделе "Рекомендуемые исполнители"
								</td>
							</tr>
						</table>
						<table class="middle">
							<tr>
								<th>
									<h3>Базовый аккаунт<br> БЕСПЛАТНО</h3>
									ваш текущий акканут
								</th>
							</tr>
							<tr>
								<td>
									<span>10 загрузок в неделю</span>
									Создайте портфолио с вашими<br> лучшими работами
								</td>
							</tr>
							<tr>
								<td>
									<span>1 специализация на выбор</span>
									Вы можете выбрать одну специализацию<br> в категориях фото и видео
								</td>
							</tr>
							<tr>
								<td>
									<span>1 загрузка видео в неделю</span>
								</td>
							</tr>
							<tr>
								<td>
									<span>3 ответа на проект в неделю</span>
								</td>
							</tr>
						</table>
						<table class="high">
							<tr>
								<th>
									<h3><b>PRO</b> аккаунт <br>{{ round($pricePro) }} руб. / мес</h3>
									<a href="/account/buy/pro" class="add fancybox_ajax">
									@if($userInfo->pro < date('Y-m-d'))	
										Оформить
									@else
										Продлить 
									@endif
									PRO на 1 месяц
									</a>
								</th>
							</tr>
							<tr>
								<td>
									<span>Безлимитная загрузка</span>
									Загружайте любое количество <br>фотографий и видеороликов<br> без ограничений
								</td>
							</tr>
							<tr>
								<td>
									<span>Любое количество специализаций</span>
									Вы можете выбрать неограниченное <br>количество специализаций
								</td>
							</tr>
							<tr>
								<td>
									<span>Загрузка обложки профиля</span>
									Вы можете загрузить любую <br>обложку для своего профиля
								</td>
							</tr>
							<tr>
								<td>
									<span>Логотип PRO рядом с ником</span>
									Указывает на высокий Ваш рейтинг и <br>статус на проекте. Тем самым<br> увеличивает доверие к Вам
								</td>
							</tr>
							<tr>
								<td id="promo">
									<span>Безлимитные ответы на проекты</span>
									Вы можете отвечать на неограниченное <br>количество проектов
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			@if(Auth::user()->role_id != 2)
				<div class="promo">
					<div class="row">
						<div class="col-md-12 section-title decor">
							Промо-размещение — Ваше портфолио всегда наверху!
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<p>Воспользовавшись услугой промо-размещения вы получите возможность публикации Вашего портфолио на самом заметном месте сайта — на главной странице и в верхней части каталога исполнителей и страниц результатов поиска, над обычными портфолио.</p>
							<img src="/assets/img/promo.png" alt="">
							<a href="/account/buy/promo" class="by-promo fancybox_ajax">
								@if($userInfo->promo < date('Y-m-d'))	
									Оформить 
								@else
									Продлить
								@endif
								ПРОМО-размещение на 7 дней за {{ round($pricePromo) }} руб.
							</a>
						</div>
					</div>
				</div>	
			@endif
		</div>
	</div>	
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$('.by-promo').on('click',function(){
				$('html, body').animate({
			        scrollTop: $("#promo").offset().top
			    }, 1000);
			})
		})
	</script>
@stop