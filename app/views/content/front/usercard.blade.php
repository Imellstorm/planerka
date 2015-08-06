<article id="card">
	@if(!isset($hideDel))
		<a href="/favorites/delete/{{ $item->id }}" class="fa fa-times delete-image" onclick="return confirm('Удалить?')?true:false;"></a>
	@endif
	<figure>
		<a href="/{{ $item->alias }}" class="usercard_photo">
			@if(!empty($item->usercard_cover))
				<img src="/{{ $item->usercard_cover }}" alt="">
			@else
				<div class="usercard_no_photo">
					<img src="/assets/img/no_image.png" style="width:initial; height:initial">
				</div>
			@endif
		</a>
	</figure>
	<div class="user-info">
		<a href="/{{ $item->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($item->user_id) }}" alt=""></a>
		<div class="info-cont">
			<div class="pull-left {{ !empty($item->online)?'online':'offline' }}" style="margin: 5px 5px 0 0;"></div>
			<div class="name">
				@if(!empty($item->name) || !empty($item->surname))
					<a href="/{{ $item->alias }}">{{ $item->name }} {{ $item->surname }}</a>
				@else
					<a href="/{{ $item->alias }}">{{ $item->alias }}</a>
				@endif
			</div>
			@if($item->pro > date('Y-m-d'))
				<span class="status">PRO</span>
			@else
				<span class="status not_active">PRO</span>
			@endif
			<div class="rait">Рейтинг:&nbsp;&nbsp;{{ $item->rating }}</div>
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
				<span class="{{ !empty($item->online)?'online':'offline' }}"></span>
			</div>
			@if($item->pro > date('Y-m-d'))
				<span class="status">PRO</span>
			@endif
			<span class="place">{{ $item->city }}</span>

			<div class="meta">
				<div class="pull-left">
					<div class="review"><span>{{ $item->reviews }}</span>отзывов</div>
					<div class="orders"><span>{{ $item->projects }}</span>заказов</div>
				</div>
				@if(Auth::check() && isset($hideDel))
					<div style="float: right; margin-left: 10px;">
						@if(!in_array($item->user_id,$favorites))
		                    <a href="/favorites/save/{{ $item->alias }}">
		                        <img src="/assets/img/star.png" title="Добавить в избранное">
		                    </a>
		                @else
		                    <a href="/favorites/delete/{{ $item->user_id }}">
		                        <img src="/assets/img/star_nocolor.png" title="Убрать из избранного">
		                    </a>
		                @endif
		        	</div>
	        	@endif
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
			@if(Auth::user()->id != $item->user_id)
				<a href="/message/create/{{ $item->user_id }}" class="btn-message fancybox_ajax">Сообщение</a>
			@endif
			@if(Auth::user()->role_id==2 && $item->role_id!=2)
				<a href="/project/inviteperformer/{{ $item->user_id }}" class="btn-order fancybox_ajax">Заказать</a>
			@endif
		@endif							
	</div>
</article>