@extends('containers.frontend')

@section('title') {{ 'Мероприятия' }} @stop

@section('main')
	<div id="main">
		<div class="project-list">
			<div class="container">
				<div class="row">
					<div class="col-md-12 section-title decor">
						Лента проэктов
					</div>
				</div>
				@if(Auth::check() && Auth::user()->role_id!=2)
					<div class="row">
						<div class="col-sm-12">
							<div class="no-pro-msg">
								Осталось ответов на проекты: <span>3</span>. Купите аккаунт <div class="status">PRO</div> и отвечайте без ограничений.
								<a href="/project/filtr" class="btn-main fancybox_ajax" style="width:150px; float:right; margin: 20px 20px 0 0;">Фильтр</a>
								@if(!empty($filtr))
									<a href="/project/list" class="btn-main" style=" float:right; margin: 20px 20px 0 0;">Очистить фильтр</a>
								@endif
							</div>
						</div>
					</div>
				@endif
				@if(count($projects))
					<div class="row">
						<div class="col-sm-12">
							@foreach($projects as $project)
								<div class="single-proj">
									<header>
										<div class="title">
											<a href="/project/singl/{{ $project->id }}">{{ $project->title }}</a>
										</div>
										<div style="position:absolute; right:30px">
											<div class="price">{{ $project->budget }} руб.</div>
											<div style="margin-top:20px"><a href="/project/singl/{{ $project->id }}" class="btn-main">Просмотреть</a></div>
										</div>
									</header>
									<div class="text">
										{{ $project->description }}
									</div>
									<ul class="meta-list">
										@if($project->pro_only)
											<li><span class="only-pro">Только для PRO</span></li>
										@endif
										<li>Создан: <span>{{ date('d-m-Y',strtotime($project->created_at)) }}</span></li>
										<li>Ответов: <span>{{ $project->messcount }}</span></li>
									</ul>
								</div>
							@endforeach
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							{{ $projects->links() }}
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
@stop	