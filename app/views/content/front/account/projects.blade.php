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
												<a href="/{{ $project->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($project->user_id) }}" alt=""></a>
												<div class="name">
													<a href="/{{ $project->alias }}">{{ $project->name }} {{ $project->surname }}</a>
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
												<div class="title"><a href="/project/singl/{{ $project->id }}" style="color:#44B39B">{{ $project->title }}</a></div>
												<div class="price">{{ $project->budget }} руб.</div>
											</header>
											<div class="text">{{ $project->description }}</div>
											<ul class="meta-list">
												<li>Добавлен: <span>{{ date('d-m-Y',strtotime($project->created_at)) }}</span></li>
												<li>Город: <span>{{ $project->city }}</span></li>
												@if(Auth::user()->role_id!=2)
													<li>Статус: 
														<span>
															<?php switch ($project->status) {
																case 2:
																	echo 'Вы выбраны в качестве исполнителя';
																	break;
																case 3:
																	echo 'Заказ принят';
																	break;
																case 4:
																	echo 'Вам отказали';
																	break;
																case 6:
																	echo 'Проект закрыт';
																	break;
																																			
																default:
																	echo 'Вы подписались на проект';
																	break;
															}?>
														</span>
													</li>
												@endif
											</ul>
											@if(Auth::user()->role_id!=2)
												@if($project->status!=6)
													<a href="/project/singl/{{ $project->id }}" class="btn-purple">Обсудить условия</a>
												@elseif(empty($project->review))
													<a href="/review/form/{{ $project->user_id }}/{{ $project->id }}" class="btn-purple fancybox_ajax">Оставить отзыв</a>
												@endif
												@if($project->status==2)
													<a href="/project/changestatus/{{ $project->users_to_project_id }}/3" class="btn-main">Принять заказ</a>
												@endif
												@if($project->status==1 || $project->status==2)
													<a href="/project/changestatus/{{ $project->users_to_project_id }}/5" class="btn-disable">Отказаться от заказа</a>
												@endif
												@if($project->status==3)
													<a href="/project/changestatus/{{ $project->users_to_project_id }}/6" class="btn-main">Завершить проект</a>
												@endif
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