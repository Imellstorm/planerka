<div class="item" style="margin-top:20px">
	<div class="name">
		<a href="/{{ $message->alias }}" style="color:#3C3C3C">{{ $message->name }} {{ $message->surname }}</a>
		<span class="online"></span>
	</div>
	<div class="date">{{ $message->created_at }}</div>
	<div class="chat-msg">{{ $message->text }}</div>
	@if(!empty($message->price))
		<div class="wite_badge">
			Стоимость {{ $message->price }}
		</div>
	@endif
	@if(!empty($message->term))
		<div class="wite_badge">
			Срок {{ $message->term }}
		</div>
	@endif
	<div style="clear:both"></div>
	<div class="albums_list">
		@if(isset($albums[$message->id])&&!empty($albums[$message->id]))
			@foreach($albums[$message->id] as $album)
				<a href="/{{ $message->alias }}/album/{{ $album->id }}" target="blank">
					@if(!empty($album->image))
						<img src="/{{ $album->image }}">
					@else
						<img src="/assets/img/noimage.png" style="width:212px;">				
					@endif
				</a>
			@endforeach
		@endif
	</div>
</div>