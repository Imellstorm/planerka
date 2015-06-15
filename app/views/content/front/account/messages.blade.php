@extends('containers.frontend')

@section('title') {{ 'Сообщения' }} @stop

@section('main')
	<!-- MAIN CONTENT
	============================= -->	
	<div id="main">
		<!-- admin massage -->
		<div class="notification">
			<div class="container">
				@include('content.front.account.menu_two')
				<a href="/message/create/{{ $userId }}" class="reply fancybox_ajax btn-main" style="margin:20px auto 0 auto">Ответить</a>
				@if(count($messages))
					<div class="row">
						<div class="col-sm-12">
							<div class="notif-content">
								@foreach($messages as $message)
									<div class="single-msg" style="border:none">
										<div class="user-info">
											<a href="/{{ $message->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($message->from) }}" alt=""></a>
											<div class="name">
												@if(!empty($message->name) || !empty($message->surname))
													<a href="/{{ $message->alias }}">{{ $message->name }} {{ $message->surname }}</a>
												@else
													<a href="/{{ $message->alias }}">{{ $message->alias }}</a>
												@endif
												<span class="online"></span>
												@if(!empty($message->pro))
													<span class="status">PRO</span>
												@endif
											</div>
											<span class="place">{{ $message->city }}</span>
											<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
										</div>
										<div class="msg-cont">
											<div class="time">{{ $message->created_at }}</div>
											<div class="text-msg">{{ $message->text }}</div>		
										</div>
									</div>
								@endforeach	
							</div>
							{{ $messages->links() }}
						</div>
					</div>
				@endif
			</div>
		</div>	
	</div>	
@stop