@extends('containers.frontend')

@section('title') {{ 'Уведомления' }} @stop

@section('main')
	<!-- MAIN CONTENT
	============================= -->	
	<div id="main">
		<!-- admin massage -->
		<div class="notification">
			<div class="container">
				@include('content.front.account.menu_two')
				<div class="row">
					<div class="col-sm-12">
						@if(count($notifications))
							<div class="notif-content">	
								@foreach($notifications as $noty)						
									<div class="single-notif">
										<div class="user-info">
											<a href="/{{ $noty->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($noty->from_user) }}" alt=""></a>
											<div class="name">
												<a href="/{{ $noty->alias }}">{{ $noty->name }} {{ $noty->surname }}</a>
												<span class="online"></span>
												@if(!empty($noty->pro))
													<span class="status">PRO</span>
												@endif
											</div>
											<span class="place">{{ $noty->city }}</span>
											<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
										</div>
										<div class="notif-text">
											<span class="photo-like">
												<div class="pull-left">
													@if($noty->readed==0)
														<div class="new_mess_badge text-center" style="font-size:14px; width:100px">Новое</div>
													@endif 
													<div>{{ $noty->text }}</div>
													<a href="/{{ $noty->link }}" style="color:#44B39B">Посмотреть</a>
												</div>
												@if(!empty($noty->image))
													<a href="/{{ $noty->link }}">
														<img src="/{{ $noty->image }}" alt="">
													</a>
												@endif
											</span>
										</div>
										<div class="notif-time">
											{{ $noty->created_at }}
										</div>
									</div>
								@endforeach
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>	
	</div>	
@stop