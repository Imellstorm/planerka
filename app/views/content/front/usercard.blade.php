<article id="card">
	@if(!isset($hideDel))
		<a href="/favorites/delete/{{ $item->id }}" class="fa fa-times delete-image" onclick="return confirm('Удалить?')?true:false;" style="right:25px"></a>
	@endif
	<figure>
		<a href="/{{ $item->alias }}"><img src="/assets/img/photog.jpg" alt=""></a>
	</figure>
	<div class="user-info">
		<a href="/{{ $item->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($item->user_id) }}" alt=""></a>
		<div class="info-cont">
			<div class="name">
				@if(!empty($item->name) || !empty($item->surname))
					<a href="/{{ $item->alias }}">{{ $item->name }} {{ $item->surname }}</a>
				@else
					<a href="/{{ $item->alias }}">{{ $item->alias }}</a>
				@endif
				@if($item->pro!=0)
					<span class="status">PRO</span>
				@endif
			</div>
			<span class="{{ !empty($item->online)?'online':'offline' }}"></span>
			<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
			<div class="place" style="height:20px">{{ $item->city }}</div>
		</div>
	</div>
	<div class="detail-info">
		<header>
			<a href="/{{ $item->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($item->user_id) }}" alt=""></a>
			<div class="name">
				@if(!empty($item->name) || !empty($item->surname))
					<a href="/{{ $item->alias }}">{{ $item->name }} {{ $item->surname }}</a>
				@else
					<a href="/{{ $item->alias }}">{{ $item->alias }}</a>
				@endif
				<span class="online"></span>
				@if($item->pro!=0)
					<span class="status">PRO</span>
				@endif
			</div>
			<span class="place">{{ $item->city }}</span>
			<div class="meta">
				<div class="review"><span>{{ $item->reviews }}</span>отзывов</div>
				<div class="orders"><span>{{ $item->projects }}</span>заказов</div>
				<!-- <div class="rait"><img src="/assets/img/star.png" alt=""></div> -->
			</div>
		</header>
		@if(count($item->albums))
			<ul class="portfolio">
				@foreach($item->albums as $album)
					<li>
						<a href="/{{ $item->alias }}/album/{{ $album->id }}">
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
				@if($item->role_id==2)
					<p>Заказчик</p>
				@else
					@if(count($item->specializations))
						@foreach($item->specializations as $spec)
							<p>{{ $spec->name }} <span>от {{ $spec->price }}</span></p>
						@endforeach
					@endif
				@endif
			</div>
		@if(Auth::check())
			<a href="/message/create/{{ $item->user_id }}" class="btn-message fancybox_ajax">Сообщение</a>
			@if(Auth::user()->role_id==2 && $item->role_id!=2)
				<a href="/project/inviteperformer/{{ $item->user_id }}" class="btn-order fancybox_ajax">Заказать</a>
			@endif
		@endif							
	</div>
</article>