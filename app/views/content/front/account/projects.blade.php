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
				@if(count($projects))
					<div class="row">
						<div class="col-sm-12">
							<div class="notif-content">	
								@foreach($projects as $project)					
									<div class="single-order">
										@if(Auth::user()->role_id!=2)
											<div class="user-info">
												<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
												<div class="name">
													<a href="#null">{{ $project->name }} {{ $project->surname }}</a>
													<span class="online"></span>
													@if($project->pro)
														<span class="status">PRO</span>
													@endif
												</div>
												<span class="place">{{ $project->city }}</span>
											</div>
										@endif
										<div class="order-body">
											<header>
												<div class="title">{{ $project->title }}</div>
												<div class="price">{{ $project->budget }} руб.</div>
											</header>
											<div class="text">{{ $project->description }}</div>
											<ul class="meta-list">
												<li>Добавлен: <span>{{ date('d-m-Y',strtotime($project->created_at)) }}</span></li>
												<li>Город: <span>{{ $project->city }}</span></li>
												<li>Статус: <span>Не принят</span></li>
											</ul>
											@if(Auth::user()->role_id!=2)
												<a href="#null" class="btn-purple">Обсудить условия</a>
												<a href="#null" class="btn-main">Принять заказ</a>
												<a href="#null" class="btn-disable">Отказаться от заказа</a>
											@endif
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>	
	</div>	
@stop