<div class="row">
    <div class="col-sm-12">
        <ul class="inner-nav">
            <li><a href="/{{ $user->alias }}/photo" class="{{ Request::segment(2)=='photo'?'active':'' }}">Фотографии</a></li>
            <li><a href="/{{ $user->alias }}/video" class="{{ Request::segment(2)=='video'?'active':'' }}">Видео</a></li>
            <li><a href="/{{ $user->alias }}/reviews" class="{{ Request::segment(2)=='reviews'?'active':'' }}">Отзывы</a></li>
            <li><a href="/{{ $user->alias }}/calendar" class="{{ Request::segment(2)=='calendar'?'active':'' }}">Календарь</a></li>
            @if(Auth::check() && Auth::user()->role_id==2)
            	<li class="last"><a href="#null" class="btn-main">Заказать</a></li>
            @endif
        </ul>
    </div>
</div>