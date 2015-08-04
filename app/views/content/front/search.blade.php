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
					Результаты поиска
				</div>
			</div>
			<div class="text-center">
				@if(count($promo))
					@foreach($promo as $item)
						<div class="user_card_cont">
							@include('content.front.usercard')
						</div>
					@endforeach
				@endif
				@if(count($normal))
					@foreach($normal as $item)
						@include('content.front.usercard')
					@endforeach
				@endif
				@if(!count($promo) && !count($normal))
					<div class="text-center">Ничего не найдено</div>
				@endif
			</div>
			{{ $normal->links() }}
		</div>
	</div>
@stop