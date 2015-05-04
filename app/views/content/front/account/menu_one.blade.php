<div class="row">
    <div class="col-sm-12">
        <ul class="inner-nav">
            <li><a href="/account/profile" class="{{ Request::segment(2)=='profile'?'active':'' }}">Профиль</a></li>
            <li><a href="/account/specialization" class="{{ Request::segment(2)=='specialization'?'active':'' }}">Специализация</a></li>
            <li><a href="/account/info" class="{{ Request::segment(2)=='info'?'active':'' }}">Аккаунт</a></li>
        </ul>
    </div>
</div>