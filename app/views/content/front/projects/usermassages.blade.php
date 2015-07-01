@extends('containers.frontend')

@section('title') {{ 'Мероприятие' }} @stop

@section('main')

	<div class="container">
		<div class="project">
			<div class="row">
				<div class="col-sm-12">
					<div class="proj-card">
						<header>
							<div class="title">{{ $project->title }}</div>
							<div class="price">{{ $project->budget }} руб.</div>
						</header>
						<div class="cont">	
							<div>
								{{ $project->description }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		@if(empty($project->closed) && empty($declined))
			@include('content.front.projects.chatform')
		@endif
		@if(count($messages))
			<div class="order-review" style="border:none">
				<div class="chat">
					@foreach($messages as $key=>$message)
						@if($message->role_id==2 && !isset($messages[$key+1]))
						@else
							@include('content.front.projects.chatlist')
						@endif
					@endforeach
				</div>
			</div>
		@endif
		<a href="/project/singl/{{ $project->project_id }}" class="btn-main">Вернуться назад</a>
	</div>
@stop