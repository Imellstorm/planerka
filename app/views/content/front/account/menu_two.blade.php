<div class="row">
	<div class="col-sm-12">
		<ul class="notif-list">
			<li><a href="/account/orders" class="{{ Request::segment(2)=='orders'?'active':'' }}">Заказы</a></li>
			<li><a href="/account/notifications" class="{{ Request::segment(2)=='notifications'?'active':'' }}">Уведомления</a></li>
			<li><a href="/account/messages" class="{{ Request::segment(2)=='messages'?'active':'' }}">Сообщения</a></li>
		</ul>
	</div>
</div>