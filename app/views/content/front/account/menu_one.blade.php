<div class="row">
    <div class="col-sm-12">
        <ul class="inner-nav">
            <li><a href="/account/info" class="{{ Request::segment(2)=='info'?'active':'' }}">Профиль</a></li>
            @if(Auth::user()->role_id!=2)
            	<li><a href="/account/specialization" class="{{ Request::segment(2)=='specialization'?'active':'' }}">Специализация</a></li>
            @endif
            <li><a href="/account/settings" class="{{ Request::segment(2)=='settings'?'active':'' }}">Аккаунт</a></li>
        </ul>
    </div>
</div>