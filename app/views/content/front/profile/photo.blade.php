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
                    @if(!empty($albums))
                        <div class="profile-albums">
                            @foreach($albums as $album)
                                <div class="album">
                                    <a href="/{{ $user->alias }}/album/{{ $album->id }}" class="overflow" style="backgrount:grey">
                                        @if(!empty($album->image))
                                            <img src="{{ $album->image }}" alt="">
                                        @endif
                                    </a>
                                    <h4><a href="#null">{{ $album->name }}</a></h4>
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
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($otherProf))
                        @foreach($otherProf as $key=>$val)
                            <div class="profile-info">
                                <h3>{{ $val->name }}</h3>
                                <span class="price">от {{ $val->price }}</span>
                                <p>{{ $val->description }}</p>
                            </div>
                        @endforeach
                    @endif

                    <div class="add_album">
                        <a href="#create-album" class="fancybox"></a>
                        <p>Создать новый альбом</p>
                        <span>+</span>
                    </div>

                    <div class="custom-modal" id="create-album" style="">
                        <div class="title">Создать альбом</div>
                        {{ Form::open(array('role' => 'form', 'url' => '/album/store', 'method' => 'post',)) }}
                            <div class="form-group">
                                <label for="">Название</label>
                                <input required type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Описание</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                            <input type="submit" class="btn-main" value="Создать альбом">
                        {{ Form::close() }}                     
                    </div>  
                </div>
            </div>
        </div>
    </div> 
@stop

@section('styles')
<style type="text/css">
.fancybox-wrap {
  top: 50px !important;
}
#header .user-nav .logo {
  margin-top: 6px;
}
</style>
@stop