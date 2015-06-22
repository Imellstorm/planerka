@extends('containers.frontend')

@section('title') {{ 'Уведомления' }} @stop

@section('main')
<!-- MAIN CONTENT
	============================= -->	
	<div id="main">
		<!-- search reasult page -->
		<div class="container search-result">
			<div class="row">
				<div class="col-md-12 section-title decor">
					Избранное
				</div>
			</div>
			<div class="row">
				@if(!empty($favorites))
					@foreach($favorites as $item)
						<div class="col-md-3 col-sm-6">
							@include('content.front.usercard')
						</div>
					@endforeach
				@endif
			</div>
		</div>
	</div>
@stop