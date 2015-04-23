<ul class="nav nav-tabs nav-tab-vartical" role="tablist">
  <li class="{{ Request::segment(3)==''?'active':'' }}"><a href="/account/posts">Мои объявления</a></li>
  <li class="{{ Request::segment(3)=='create'?'active':'' }}"><a href="/account/posts/create">Создать новое</a></li>
  <li class="{{ Request::segment(3)=='edit'?'active':'hide' }}"><a href="#">Редактировать</a></li>
  <li class="{{ Request::segment(3)=='vip'?'active':'hide' }}"><a href="#">VIP объявление</a></li>
</ul>
<div class="tab-content" style="overflow-y:hidden; overflow-x:auto; margin-bottom:20px">
	{{ $postContent }}
</div>