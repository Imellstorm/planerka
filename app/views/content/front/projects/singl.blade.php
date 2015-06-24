@extends('containers.frontend')

@section('title') {{ 'Мероприятие' }} @stop

@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		var albIds = [];
		$('body').on('click','.album_image',function(){
			var exist = $.inArray($(this).attr('album_id'),albIds);
			if(exist!=-1){
				alert('Данный альбом уже добавлен');
			} else {
				$('.albums').val($('.albums').val()+$(this).attr('album_id')+',');
				$('.album-input').before('<img src="'+$(this).attr('src')+'">');
				albIds.push($(this).attr('album_id'));
				$('.albumsIds').val(albIds);
			}
			$.fancybox.close();
		})

		$('body').on('keydown','.price-input',function (e) {
	        // Allow: backspace, delete, tab, escape, enter and .
	        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
	             // Allow: Ctrl+A
	            (e.keyCode == 65 && e.ctrlKey === true) ||
	             // Allow: Ctrl+C
	            (e.keyCode == 67 && e.ctrlKey === true) ||
	             // Allow: Ctrl+X
	            (e.keyCode == 88 && e.ctrlKey === true) ||
	             // Allow: home, end, left, right
	            (e.keyCode >= 35 && e.keyCode <= 39)) {
	                 // let it happen, don't do anything
	                 return;
	        }
	        // Ensure that it is a number and stop the keypress
	        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	            e.preventDefault();
	        }
	    });
	})
</script>
@stop

@section('main')
	<div id="main">
		<div class="project">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="proj-card">
							<header>
								<div class="title">{{ $project->title }}</div>
								@if(Auth::check() && Auth::user()->id==$project->user_id)
									<a href="/project/delete/{{ $project->project_id }}" style="float:right; margin-left:20px" class="btn-main">Удалить проект</a>
								@endif
								<div class="price">{{ $project->budget }} руб.</div>
							</header>
							<div class="cont">
								<div class="row">
									<div class="col-md-12">
										<div class="user-info">
											<a href="#null" class="avatar"><img src="{{ Common_helper::getUserAvatar($project->user_id) }}" alt=""></a>
											<div class="name">
												@if(!empty($project->name) || !empty($project->surname))
													<a href="/{{ $project->alias }}">{{ $project->name }} {{ $project->surname }}</a>
												@else
													<a href="/{{ $project->alias }}">{{ $project->alias }}</a>
												@endif
												<span class="online"></span>
												@if($project->pro)
													<span class="status">PRO</span>
												@endif
											</div>
											<span class="place">{{ $project->city }}</span>
											<div class="reg">Зарегистрирован на сайте: <span>
												 {{ Common_helper::getPastTime($project->usercreated) }}
											</span></div>
										</div>
										<div class="msg">
											{{ $project->description }}
										</div>
										<ul class="tag">
											<li>Раздел</li>
											<li><a>{{ $project->rolename }}</a></li>
										</ul>
										<ul class="tag" style="margin-top:10px">
											<li style="width:48px">Город</li>
											@if(!empty($project->project_city))
												<li><a>{{ $project->project_city }}</a></li>
											@else
												<li><a>{{ $project->city }}</a></li>
											@endif
										</ul>
										@if($project->date!='0000-00-00')
											<ul class="tag" style="margin-top:10px">
												<li style="width:48px">Дата</li>
												<li><a>{{ $project->date }}</a></li>
											</ul>
										@endif
	
									</div>
									@if(!empty($project->thumb))
										<div class="col-md-12" style="margin-top:20px">
											<img src="/{{ $project->thumb }}" style="width:100%; max-widtH:160px">
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>

				@if(Auth::user()->role_id!=2)
					@if(empty($projectAssign))
						<div class="row">
							<div class="col-sm-12">
								<div class="proj-answ">
									<div class="title">Ваш ответ на проект</div>
									<div class="no-pro-msg">
										Осталось ответов на проекты: <span>3</span>. Купите аккаунт <div class="status">PRO</div> и отвечайте без ограничений.
									</div>
									{{ Form::open(array('role' => 'form', 'url' => 'projectmessages/store')) }}
										<div class="form-group">
										    {{ Form::label('price', 'Стоимость') }}
	            							{{ Form::text('price', null, array('class' => 'form-control price-input','placeholder'=>'в рублях','required')) }}

											{{ Form::label('term', 'Срок', array('style'=>'text-align:right;padding-right:20px;')) }}
	            							{{ Form::text('term', null, array('class' => 'form-control','required')) }}
										</div>
										<div class="form-group">
											{{ Form::label('text', 'Текст ответа') }}
	            							{{ Form::textarea('text', null, array('class' => 'form-control','style'=>'height:150px','required')) }}
										</div>
										{{ Form::hidden('project_id', $project->project_id) }}
										{{ Form::hidden('to_user', $project->user_id) }}

										<label for="" class="pull-left">Прикрепить альбомы</label>
										<div class="form-group album-load" style="margin-left:140px">
											<a href="/album/list" class="album-input fancybox_ajax"></a>	
											<input type="hidden" name="albums" class="albumsIds">			
										</div>
										<div class="form-group">
											<input type="submit" class="btn-main" value="Ответить на проект">
										</div>
									{{ Form::close() }}
								</div>
							</div>
						</div>
					@else
						@include('content.front.projects.chatform')
					@endif
					@if(count($projectMessages))
						<div class="order-review">
							<div class="chat">
								@foreach($projectMessages as $message)
									@include('content.front.projects.chatlist')
								@endforeach
							</div>
						</div>
					@endif
				@else
					@if(count($usersToProject))
						<div class="proj-prop" style="margin:0;padding:0;border-bottom:none">
							<div class="order-review" style="border:none">
								@foreach($usersToProject as $key=>$performer)
									<div style="border-bottom:solid 1px #44B39B">
										<div class="user-info" style="padding-top:20px;">
											<a href="/{{ $performer->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($performer->user_id) }}" alt=""></a>
											<div class="info-cont">
												<div class="name">
													@if(!empty($performer->name) || !empty($performer->surname))
														<a href="/{{ $performer->alias }}">{{ $performer->name }} {{ $performer->surname }}</a>
													@else
														<a href="/{{ $performer->alias }}">{{ $performer->alias }}</a>
													@endif
													<span class="online"></span>
													@if(!empty($performer->pro))
														<span class="status">PRO</span>
													@endif
												</div>
												<div class="place">{{ $performer->city }}</div>
												<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
												<div class="reg">Зарегистрирован на сайте: <span>{{ Common_helper::getPastTime($performer->created_at) }}</span></div>
											</div>
										</div>
										@if(!empty($performer->mainMessage))
											<div class="prop-body">
												<ul class="raider">
													<li>Стоимость:  <span>{{ $performer->mainMessage['price'] }} руб</span></li>
													<li>Срок:  <span>{{ $performer->mainMessage['term'] }}</span></li>
												</ul>
												<p>{{ $performer->mainMessage['text'] }}</p>
												@if(isset($performer->albums) && !empty($performer->albums))
													<div class="portf">
														@foreach($performer->albums as $album)
															<a href="/{{ $performer->alias }}/album/{{ $album->id }}"><img src="/{{ $album->image?$album->image:'assets/img/noimage.png' }}" alt=""></a>
														@endforeach
													</div>
												@endif
											</div>
											<footer>
												@if(!empty($newProjectMessages))
				                                    <div class="new_mess_badge">Есть новые сообщения</div>
				                                @endif
												<a href="/project/usermassages/{{ $performer->user_id }}/{{ $project->project_id }}" class="btn-main">История сообщений</a>
												@if($project->closed!=1)
													@if($performer->status==1 && empty($existPerformer))
														<a href="/project/changestatus/{{ $performer->users_to_project_id }}/2" class="btn-main">Выбрать исполнителем</a>
														<a href="/project/changestatus/{{ $performer->users_to_project_id }}/4" class="btn-purple">Отказать</a>
													@endif
													@if($performer->status==3)
														<a href="/project/changestatus/{{ $performer->users_to_project_id }}/6" class="btn-main">Завершить проект</a>
													@endif
												@else
													@if($performer->status==6 && empty($existReview))
														<a href="/review/form/{{ $performer->user_id }}/{{ $project->project_id }}" class="btn-main fancybox_ajax">Оставить отзыв</a>
													@endif
												@endif
											</footer>
										@endif
									</div>
								@endforeach	
							</div>
						</div>
					@endif
				@endif
			</div>
		</div>	
	</div>
@stop