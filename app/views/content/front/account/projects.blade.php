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
						{{ $projects->links() }}
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="notif-content">	
								@foreach($projects as $project)					
									<div class="single-order">
										@if(Auth::user()->role_id!=2)
											<div class="user-info">
												<a href="/{{ $project->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($project->user_id) }}" alt=""></a>
												<div class="name">
												@if(!empty($project->name) || !empty($project->surname))
													<a href="/{{ $project->alias }}">{{ $project->name }} {{ $project->surname }}</a>
												@else
													<a href="/{{ $project->alias }}">{{ $project->alias }}</a>
												@endif
													<span class="{{ $project->online?'online':'offline' }}"></span>
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
											@if(!empty($project->new))
												<div class="new_mess_badge text-center" style="margin-top:20px;">
													Новый заказ
												</div>
											@elseif(!empty($project->new_subscriber))
												<div class="new_mess_badge text-center" style="margin-top:20px;">
													Новый исполнитель
												</div>
											@elseif(!empty($project->new_messages))
												<div class="new_mess_badge text-center" style="margin-top:20px;">
													Новые сообщения - {{ $project->new_messages }}
												</div>
											@endif
											<ul class="meta-list">
												<li>Добавлен: <span>{{ date('d-m-Y H:i:s',strtotime($project->created_at)) }}</span></li>

												@if(isset($project->project_city) && !empty($project->project_city))
													<li>Город: <span>{{ $project->project_city }}</span></li>
												@elseif(!empty($project->city))
													<li>Город: <span>{{ $project->city }}</span></li>
												@endif

												@if(Auth::user()->role_id!=2)
													<li>Статус: 
														<span style="max-width:200px; display:block;">
															<?php switch ($project->status) {
																case 2:
																	echo 'Вы выбраны в качестве исполнителя';
																	break;
																case 3:
																	echo '<span style="color:#44B39B">Заказ принят</span>';
																	break;
																case 4:
																	echo 'Вам отказали';
																	break;
																case 6:
																	echo 'Проект закрыт';
																	break;
																																			
																default:
																	echo 'Вы подписаны на проект';
																	break;
															}?>
														</span>
													</li>
												@else
													<li>Статус: 
														@if($project->closed==1)
															<span>Проект закрыт</span>
														@else
															<span style="color:#44B39B">Проект активен</span>															
														@endif
													</li>
												@endif
											</ul>
											@if(Auth::user()->role_id!=2)
												@if($project->status!=6 && $project->status!=4)
													<a href="/project/singl/{{ $project->id }}" class="btn-purple">Обсудить условия</a>
												@elseif(empty($project->review) && $project->status!=4)
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
					<div class="row">
						{{ $projects->links() }}
					</div>
				@endif
			</div>
		</div>	
	</div>	
@stop