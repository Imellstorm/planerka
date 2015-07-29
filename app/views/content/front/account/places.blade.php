@extends('containers.frontend')

@section('title') Размещение рекламы @stop

@section('main')
<!-- MAIN CONTENT
	============================= -->	
	<div id="shop">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-title decor">
					Тарифы на размещение рекламы на сайте
				</div>
			</div>
			<div class="row">
				<div class="col-md-7">
					<div class="col-md-12"><div class="block_1"></div></div>

					<div class="col-md-3" style="padding:5px"><div class="block_2"></div></div>
					<div class="col-md-3" style="padding:5px"><div class="block_2"></div></div>
					<div class="col-md-3" style="padding:5px"><div class="block_2"></div></div>
					<div class="col-md-3" style="padding:5px"><div class="block_2"></div></div>

					<div class="col-md-9" style="padding: 20px">
						<div class="grey_line" style="width:90%"></div>
						<div class="grey_line" style="width:80%"></div>
						<div class="grey_line" style="width:70%"></div>
						<div class="grey_line" style="width:60%"></div>
						<div class="grey_line" style="width:50%"></div>
					</div>
					<div class="col-md-3" style="height:200px">
		<!-- 				<div class="block_3"></div>
						<div class="block_3"></div> -->
					</div>
					<div class="col-md-3"><div class="block_4"></div></div>
					<div class="col-md-3"><div class="block_4"></div></div>
					<div class="col-md-3"><div class="block_4"></div></div>
					<div class="col-md-3"><div class="block_4"></div></div>
				</div>
				<div class="col-md-5">
				<div class="block_1_desc">	
					<div class="blue_back">Аренда баннера сроком на 1 месяц</div>
					<div class="white_back">Баннер "ТОП" 50000 рублей</div>
				</div>
				<div class="block_2_desc">
					<div class="pink_back">Публикация статьи или новостисроком на 14 дней</div>
					<div class="white_back">Статья (новость) 5000 рублей</div>
				</div>
	<!-- 			<div class="block_3_desc">
					<div class="yellow_back">Аренда малого баннера сроком на 1 месяц</div>
					<div class="white_back">Баннер "малый" 25000 рублей</div>
				</div> -->
				<div class="block_4_desc">
					<div class="green_back">Публикация профиля на главной сроком на 1 месяц</div>
					<div class="white_back">"Лучший" 10000 рублей</div>
				</div>
					<div style="margin-bottom:10px">Любое изменение информации по заявке абонента - <i style="font-weight:bold; ">бесплатное</i></div>
					<div>Баннер малый размещается на каждой странице порталав ротации не более 2 баннеров на одном месте.</div>
					<div>При размещении баннера на срок от трёх месяцев предоставляется скидка 15%, от шести месяцев 25%</div>
					<div>Изготовление баннера - <i style="font-weight:bold; ">бесплатное</i></div>
				</div>
			</div>
		</div>
		<div class="row contact_info_line">
			<div class="col-md-6 text-right">Рекламный отдел: <span style="font-weight:bold">8 (800) 656 76 39</span></div>
			<div class="col-md-1"></div>
			<div class="col-md-5" style="font-weight:bold">admin@planerka.ru</div>
		</div>
	</div>	
@stop

@section('scripts')
	<script type="text/javascript">
	$(document).ready(function(){
		$('.block_1_desc').on('mouseover',function(){
			$('.block_1').addClass('blue-area');
		})
		$('.block_1_desc').on('mouseout',function(){
			$('.block_1').removeClass('blue-area');
		})

		$('.block_2_desc').on('mouseover',function(){
			$('.block_2').addClass('pink-area');
		})
		$('.block_2_desc').on('mouseout',function(){
			$('.block_2').removeClass('pink-area');
		})

		$('.block_3_desc').on('mouseover',function(){	
			$('.block_3').addClass('yellow-area');
		})
		$('.block_3_desc').on('mouseout',function(){
			$('.block_3').removeClass('yellow-area');
		})

		$('.block_4_desc').on('mouseover',function(){
			$('.block_4').addClass('green-area');
		})
		$('.block_4_desc').on('mouseout',function(){
			$('.block_4').removeClass('green-area');
		})
	})
	</script>
@stop