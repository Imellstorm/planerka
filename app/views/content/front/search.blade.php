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
			<div class="row">
				@if(count($result))
					@foreach($result as $item)
						<div class="col-md-3">
							@include('content.front.usercard')
						</div>
					@endforeach
				@else
					<div class="text-center">Ничего не найдено</div>
				@endif
			</div>
			{{ $result->links() }}
		</div>
	</div>
@stop