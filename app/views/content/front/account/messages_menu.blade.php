<ul class="nav nav-tabs nav-tab-vartical" role="tablist">
  <li class="{{ Request::segment(3)=='inbox'?'active':'' }}"><a href="/account/messages/inbox">Входящие</a></li>
  <li class="{{ Request::segment(3)=='outbox'?'active':'' }}"><a href="/account/messages/outbox">Исходящие</a></li>
</ul>
<div class="tab-content" style="overflow-y:hidden; overflow-x:auto; padding:20px 0 0 20px; margin-bottom:20px">
	{{ $messagesContent }}
</div>