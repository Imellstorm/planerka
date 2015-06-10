<div class="item" style="margin-top:20px">
	<div class="name">{{ $message->name }} {{ $message->surname }}<span class="online"></span></div>
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
</div>