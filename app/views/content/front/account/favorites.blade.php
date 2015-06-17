@extends('containers.frontend')

@section('title') {{ 'Уведомления' }} @stop

@section('main')
<!-- MAIN CONTENT
	============================= -->	
	<div id="main">
		<!-- search reasult page -->
		<div class="container search-result">
			<div class="row">
				<div class="col-md-12 section-title decor">
					Избранное
				</div>
			</div>
			<div class="row">
				@if(!empty($favorites))
					@foreach($favorites as $favorite)
						<div class="col-md-3 col-sm-6">
							<article id="card">
								<figure>
									<a href="#null"><img src="/assets/img/photog.jpg" alt=""></a>
								</figure>
								<div class="user-info">
									<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
									<div class="info-cont">
										<div class="name">
											@if(!empty($favorite->name) || !empty($favorite->surname))
												<a href="/{{ $favorite->alias }}">{{ $favorite->name }} {{ $favorite->surname }}</a>
											@else
												<a href="/{{ $favorite->alias }}">{{ $favorite->alias }}</a>
											@endif
											<span class="online"></span>
											@if($favorite->pro!=0)
												<span class="status">PRO</span>
											@endif
										</div>
										<div class="place">{{ $favorite->city }}</div>
										<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
									</div>
								</div>
								<div class="detail-info">
									<header>
										<a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
										<div class="name">
											@if(!empty($favorite->name) || !empty($favorite->surname))
												<a href="/{{ $favorite->alias }}">{{ $favorite->name }} {{ $favorite->surname }}</a>
											@else
												<a href="/{{ $favorite->alias }}">{{ $favorite->alias }}</a>
											@endif
											<span class="online"></span>
											@if($favorite->pro!=0)
												<span class="status">PRO</span>
											@endif
										</div>
										<span class="place">{{ $favorite->city }}</span>
										<div class="meta">
											<div class="review"><span>{{ $favorite->reviews }}</span>отзывов</div>
											<div class="orders"><span>{{ $favorite->projects }}</span>заказов</div>
											<!-- <div class="rait"><img src="/assets/img/star.png" alt=""></div> -->
										</div>
									</header>
									@if(count($favorite->albums))
										<ul class="portfolio">
											@foreach($favorite->albums as $album)
												<li>
													<a href="/{{ $favorite->alias }}/album/{{ $album->id }}">
														@if(!empty($album->image))
															<img src="/{{ $album->image }}" style="max-width:100px; height:100px">
														@else
															<img src="/assets/img/noimage.png" style="width:100px; height:100px">
														@endif
													</a>
												</li>
											@endforeach
										</ul>
									@endif
										<div class="price">
											@if($favorite->role_id==2)
												<p>Заказчик</p>
											@else
												@if(count($favorite->specializations))
													@foreach($favorite->specializations as $spec)
														<p>{{ $spec->description }} <span>от {{ $spec->price }}</span></p>
													@endforeach
												@endif
											@endif
										</div>

									<a href="/message/create/{{ $favorite->user_id }}" class="btn-message fancybox_ajax">Сообщение</a>
									@if(Auth::user()->role_id==2 && $favorite->role_id!=2)
										<a href="/project/inviteperformer/{{ $favorite->user_id }}" class="btn-order fancybox_ajax">Заказать</a>
									@endif								
								</div>
							</article>
						</div>
					@endforeach
				@endif
			</div>
		</div>
	</div>
@stop