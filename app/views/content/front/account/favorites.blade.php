@extends('containers.frontend')

@section('title') {{ 'Избранное' }} @stop

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
			<div class="row text-center">
				@if(!empty($favorites))
					@foreach($favorites as $item)
						@include('content.front.usercard')
					@endforeach
				@endif
			</div>
		</div>
	</div>
@stop