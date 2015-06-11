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
								@if(isset($dialogs) && !empty($dialogs))
									@foreach($dialogs as $key=>$dialog)
										<div class="single-msg" style="border:none">
											<div class="user-info">
												<div style="padding:10px;background:#44B39B;margin-bottom:20px;color:white">Переписка с {{ $dialog['mess'][0]->userdialog }}</div>
												<a href="/{{ $dialog['mess'][0]->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($dialog['mess'][0]->from) }}" alt=""></a>
												<div class="name">
													<a href="/{{ $dialog['mess'][0]->alias }}">{{ $dialog['mess'][0]->name }} {{ $dialog['mess'][0]->surname }}</a>
													<span class="online"></span>
													@if(!empty($dialog['mess'][0]->pro))
														<span class="status">PRO</span>
													@endif
												</div>
												<span class="place">{{ $dialog['mess'][0]->city }}</span>
												<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
											</div>
											<div class="msg-cont">
												@if(!empty($dialog['count']))
													<div class="new_mess_badge text-center">Новые сообщения - {{ $dialog['count'] }}</div>
												@endif
												<div class="time">{{ $dialog['mess'][0]->created_at }}</div>
												<div class="text-msg">{{ $dialog['mess'][0]->text }}</div>
												<a href="/account/messages/{{ $key }}" class="reply">история переписки</a>
											</div>
										</div>
									@endforeach	
								@endif
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>	
	</div>	
@stop