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
					{{ $notifications->links() }}
				</div>
				<div class="row">
					<div class="col-sm-12">
						@if(count($notifications))
							<div class="notif-content">	
								@foreach($notifications as $noty)						
									<div class="single-notif">
										<div class="user-info">
											<a href="/{{ $noty->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($noty->from_user) }}" alt=""></a>
											<div class="name">
												@if(!empty($noty->name) || !empty($noty->surname))
													<a href="/{{ $noty->alias }}">{{ $noty->name }} {{ $noty->surname }}</a>
												@else
													<a href="/{{ $noty->alias }}">{{ $noty->alias }}</a>
												@endif
												<span class="{{ $noty->online?'online':'offline' }}"></span>
												@if($noty->pro > date('Y-m-d'))
													<span class="status">PRO</span>
												@else
													<span class="status not_active">PRO</span>
												@endif
											</div>
											<span class="place">{{ $noty->city }}</span>
											<div class="rait">Рейтинг:&nbsp;&nbsp;{{ $noty->rating }}</div>
										</div>
										<div class="notif-text">
											<span class="photo-like">
												<div class="pull-left">
													@if($noty->readed==0)
														<div class="new_mess_badge text-center" style="font-size:14px; width:100px">Новое</div>
													@endif 
													<div>{{ $noty->text }}</div>
													@if(!empty($noty->link))
														<a href="/{{ $noty->link }}" style="color:#44B39B">Посмотреть</a>
													@endif
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
				<div class="row">
					{{ $notifications->links() }}
				</div>
			</div>
		</div>	
	</div>	
@stop