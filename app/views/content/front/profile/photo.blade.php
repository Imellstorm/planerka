@extends('containers.frontend')

@section('title') {{ 'Профиль|фото' }} @stop

@section('main')

<!-- MAIN CONTENT
    ============================= -->   
    <div id="user-page">
        <div class="container">
            @include('content.front.profile.menu')
            <div class="row">
                <div class="col-sm-12">
                    @if(!empty($mainProf))
                        <div class="profile-info">
                            <h3>{{ $mainProf->name }}</h3>
                            <span class="price">от {{ $mainProf->price }}</span>
                            <p>{{ $mainProf->description }}</p>
                        </div>
                    @endif
                    <div class="profile-data">
                        <dl>
                            @if(!empty($userinfo->phone))
                                <dt>Мобильний телефон</dt>
                                <dd>{{ $userinfo->phone }}</dd>
                            @endif

                            @if(!empty($userinfo->additional_email))
                                <dt>E-mail</dt>
                                <dd>{{ $userinfo->additional_email }}</dd>
                            @endif
                                
                            @if(!empty($userinfo->site))
                                <dt>Сайт</dt>
                                <dd>{{ $userinfo->site }}</dd>
                            @endif    

                            <dt>Просмотр профиля</dt>
                            <dd>{{ $userinfo->enters_count }}</dd>

                            <dt>Лайков</dt>
                            <dd>{{ $userinfo->likes }}</dd>

                            <dt>Выполненных заказов</dt>
                            <dd>{{ $userinfo->finished_jobs }}</dd>

                            <dt>Регистрация на сайте</dt>
                            <dd>
                                @if(!empty($date->years))
                                    {{ $date->years }}  
                                    <?php if($date->years == 1){
                                        echo 'год';
                                    } elseif($date->years < 5) {
                                        echo 'годa';
                                    } else {
                                        echo 'лет';
                                    }?>
                                @endif
                                @if(!empty($date->months))
                                    {{ $date->months }}  
                                    <?php if($date->months == 1){
                                        echo 'месяц';
                                    } elseif($date->months < 5) {
                                        echo 'месяца';
                                    } else {
                                        echo 'месяцев';
                                    }?>
                                @endif
                                @if(!empty($date->days))
                                    {{ $date->days }}
                                    <?php if($date->days == 1){
                                        echo 'день';
                                    } elseif($date->days < 5) {
                                        echo 'дня';
                                    } else {
                                        echo 'дней';
                                    }?>
                                @endif
                            </dd>
                        </dl>
                        <footer>
                            <p>Выезжаю в другой город - <i class="fa {{ !empty($userinfo->city_departure)?'fa-check':'fa-times' }}"></i></p>
                            <p>Выезжаю за рубеж - <i class="fa {{ !empty($userinfo->country_departure)?'fa-check':'fa-times' }}"></i></p>
                        </footer>
                    </div>
                    <div class="profile-albums">
                        <div class="album">
                            <div class="overflow"></div>
                            <a href="#null"><img src="/assets/img/album.png" alt=""></a>
                            <h4><a href="#null">Необычная свадьба <br>Саши и Миши</a></h4>
                            <p>25 фото</p>
                        </div>
                        <div class="photos">
                            <ul>
                                <li><a href="#null"><img src="/assets/img/photo.png" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/photo.png" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/photo.png" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/photo.png" alt=""></a></li>
                                <li class="add_more"><a href="#null"></a><p>Еще хочу посмотреть<br> немного фото</p><span>+ 5</span></li>
                            </ul>
                        </div>
                    </div>
                    @if(!empty($otherProf))
                        @foreach($otherProf as $key=>$val)
                            <div class="profile-info">
                                <h3>{{ $val->name }}</h3>
                                <span class="price">от {{ $val->price }}</span>
                                <p>{{ $val->description }}</p>
                            </div>
                        @endforeach
                    @endif
                    <div style="clear:both"></div>
                    <div class="add_album">
                        <a href="#null"></a>
                        <p>Создать новый альбом</p>
                        <span>+</span>
                    </div>  
                </div>
            </div>
        </div>
    </div>  
@stop