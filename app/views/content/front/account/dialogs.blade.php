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
												<a href="/{{ $dialog['dialogUserInfo']->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($key) }}" alt=""></a>
												<div class="name">
													@if(!empty($dialog['dialogUserInfo']->name) || !empty($dialog['dialogUserInfo']->surname))
														<a href="/{{ $dialog['dialogUserInfo']->alias }}">{{ $dialog['dialogUserInfo']->name }} {{ $dialog['dialogUserInfo']->surname }}</a>
													@else
														<a href="/{{ $dialog['dialogUserInfo']->alias }}">{{ $dialog['dialogUserInfo']->alias }}</a>
													@endif
													<span class="{{ $dialog['dialogUserInfo']->online?'online':'offline' }}"></span>
													@if($dialog['dialogUserInfo']->pro > date('Y-m-d'))
														<span class="status">PRO</span>
													@endif
												</div>
												<div class="place">{{ $dialog['dialogUserInfo']->city }}</div>
												<div class="rait">Рейтинг:&nbsp;&nbsp;{{ $dialog['dialogUserInfo']->rating }}</div>
											</div>
											<a href="/message/create/{{ $key }}" class="fancybox_ajax_scroll">
												<div class="msg-cont">
													<div style="color:#44B39B">Последнее сообщение от {{ $dialog['mess'][0]->alias }}</div>
													<div class="time">{{ $dialog['mess'][0]->created_at }}</div>
													<div class="text-msg">{{ $dialog['mess'][0]->text }}</div>
													@if(isset($dialog['count']) && !empty($dialog['count']))
														<div class="new_mess_badge text-center" style="margin-top:10px">новые сообщения - {{ $dialog['count'] }}</div>
													@endif
												</div>
											</a>
										</div>
									@endforeach
								@else
									<div class="text-center" style="margin-top:20px">Сообщения отсутствуют</div>
								@endif
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>	
	</div>	
@stop