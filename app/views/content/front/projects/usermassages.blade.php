@extends('containers.frontend')

@section('title') {{ 'Мероприятие' }} @stop

@section('main')
	<div class="container">
		@include('content.front.projects.chatform')
		@if(count($messages))
			<div class="order-review" style="border:none">
				<div class="chat">
					@foreach($messages as $message)
						@include('content.front.projects.chatlist')
					@endforeach
				</div>
			</div>
		@endif
		<a href="/project/singl/{{ $project->project_id }}" class="btn-main">Вырнуться назад</a>
	</div>
@stop