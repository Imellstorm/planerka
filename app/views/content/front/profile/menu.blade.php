<div class="row">
    <div class="col-sm-12">
        <ul class="inner-nav">
            <li><a href="/{{ $user->alias }}" class="{{ Request::segment(2)==''?'active':'' }}">Фотографии</a></li>
            <li><a href="/{{ $user->alias }}/video" class="{{ Request::segment(2)=='video'?'active':'' }}">Видео</a></li>
            <li><a href="/{{ $user->alias }}/reviews" class="{{ Request::segment(2)=='reviews'?'active':'' }}">Отзывы</a></li>
            @if($user->role_id!=2)
                <li><a href="/{{ $user->alias }}/calendar" class="{{ Request::segment(2)=='calendar'?'active':'' }}">Календарь</a></li>
            @endif
            @if(Auth::check() && Auth::user()->role_id==$user->role_id)
                 <li><a href="/account/favorites">Избранное</a></li>
            @endif
        </ul>
    </div>
</div>