@extends('containers.frontend')

@section('title') {{ 'Сообщения' }} @stop

@section('main')
	<!-- MAIN CONTENT
	============================= -->	
	<div id="main">
		<div class="notification">
			<div class="container">
				@include('content.front.account.menu_two')
				@if(count($dialogs))
					<div class="row">
						<div class="col-sm-12">
							<div class="notif-content">
								@foreach($dialogs as $key=>$dialog)
									<div class="single-msg" style="border:none">
										<div class="user-info">
											<div style="padding:10px;background:#44B39B;margin-bottom:20px;color:white">Переписка с {{ $dialog[0]->userdialog }}</div>
											<a href="/{{ $dialog[0]->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($dialog[0]->from) }}" alt=""></a>
											<div class="name">
												<a href="/{{ $dialog[0]->alias }}">{{ $dialog[0]->name }} {{ $dialog[0]->surname }}</a>
												<span class="online"></span>
												@if(!empty($dialog[0]->pro))
													<span class="status">PRO</span>
												@endif
											</div>
											<span class="place">{{ $dialog[0]->city }}</span>
											<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
										</div>
										<div class="msg-cont">

											<div class="time">{{ $dialog[0]->created_at }}</div>
											<div class="text-msg">{{ $dialog[0]->text }}</div>
											<a href="/account/messages/{{ $key }}" class="reply">история переписки</a>
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