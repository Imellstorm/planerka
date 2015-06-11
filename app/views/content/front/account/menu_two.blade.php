<div class="row">
	<div class="col-sm-12">
		<ul class="notif-list">
			<li>
				<a href="/account/projects" class="{{ Request::segment(2)=='projects'?'active':'' }}">Заказы</a>
				@if(!empty($newProjectMessages))
					<span class="count_circle">{{ $newProjectMessages }}</span>
				@endif
			</li>
			<li>
				<a href="/account/notifications" class="{{ Request::segment(2)=='notifications'?'active':'' }}">Уведомления</a>
				@if(!empty($newNotifications))
					<span class="count_circle">{{ $newNotifications }}</span>
				@endif
			</li>
			<li>
				<a href="/account/messages" class="{{ Request::segment(2)=='messages'?'active':'' }}">Сообщения</a>
				@if(!empty($newMessages))
					<span class="count_circle">{{ $newMessages }}</span>
				@endif
			</li>
		</ul>
	</div>
</div>