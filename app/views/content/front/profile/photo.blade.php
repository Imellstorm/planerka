@extends('containers.frontend')

@section('title') {{ 'Профиль|фото' }} @stop

@section('main')

<!-- MAIN CONTENT
    ============================= -->   
    <div id="user-page">
        <div class="container">
            @include('content.front.profile.menu')
            <div class="row" style="margin-top:20px">
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
                                <dd></dd>
                                <div style="color:#665e83;margin-bottom:10px;">{{ $userinfo->additional_email }}</div>
                            @endif
                                
                            @if(!empty($userinfo->site))
                                <dt>Сайт</dt>
                                <dd></dd>
                                <div style="color:#665e83;margin-bottom:10px;">{{ $userinfo->site }}</div>
                            @endif    

                            <dt>Просмотр профиля</dt>
                            <dd>{{ round($userinfo->enters_count) }}</dd>

                            <dt>Лайков</dt>
                            <dd>{{ $userinfo->likes }}</dd>

                            @if($userInfo->role_id!=2)
                                <dt>Выполненных заказов</dt>
                                <dd>{{ $userinfo->finished_jobs }}</dd>
                            @endif

                            <dt>Регистрация на сайте</dt>
                            <dd>
                                {{ Common_helper::getPastTime($user->created_at) }}
                            </dd>
                        </dl>
                        @if($userInfo->role_id!=2)
                            <footer>
                                <p>Выезжаю в другой город - <i class="fa {{ !empty($userinfo->city_departure)?'fa-check':'fa-times' }}"></i></p>
                                <p>Выезжаю за рубеж - <i class="fa {{ !empty($userinfo->country_departure)?'fa-check':'fa-times' }}"></i></p>
                            </footer>
                        @endif
                    </div>
                    @if(!empty($albums))
                        <div class="profile-albums">
                            @foreach($albums as $album)
                                <div class="album">
                                    <a href="/{{ $user->alias }}/album/{{ $album->id }}" class="overflow" style="backgrount:grey">
                                        @if(!empty($album->image))
                                            <img src="/{{ $album->image?$album->image:'' }}" alt="">
                                        @endif
                                        <div class="album-header">
                                            <h4>{{ $album->name }}</h4>
                                            <p>{{ $album->imgcount }} фото</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="photos">
                                    @if(count($album->images))
                                        <ul class="carusel">
                                            @foreach($album->images as $key=>$image)
                                                <li><a href="/{{ $user->alias }}/album/{{ $album->id }}"><img src="/{{ $image->thumb_small }}" alt=""></a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($otherProf))
                        @foreach($otherProf as $key=>$val)
                            <div class="profile-info" style="position:relative">
                                <h3>{{ $val->name }}</h3>
                                <span class="price">от {{ $val->price }}</span>
                                <p>{{ $val->description }}</p>
                                @if(Auth::check() && Auth::user()->id==$user->id)
            <!--                         <div class="add_album">
                                        <a href="#create-album" class="fancybox"></a>
                                        <p>Создать новый альбом</p>
                                        <span>+</span>
                                    </div> -->
                                    <a href="#create-album" class="fancybox btn-main" style="position:absolute; top:0; right:0">Создать новый альбом</a>
                                @endif
                            </div>
                        @endforeach
                    @endif

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

@section('scripts')
<script type="text/javascript" src="/assets/packs/slick/slick.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.carusel').slick({
          infinite: true,
          slidesToShow: 5,
          slidesToScroll: 5,
          prevArrow: '<span class="slick-arrow slick-next fa fa-chevron-left"></span>',
          nextArrow: '<span class="slick-arrow slick-prev fa fa-chevron-right"></span>',
        });
    })
</script>
@stop