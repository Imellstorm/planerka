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
                    <div class="info_cont">
                        @if(!empty($mainProf))
                            <div class="col-md-7">
                                <div class="profile-info">
                                    <div class="col-md-7">
                                        <h3>{{ $mainProf->name }}</h3>
                                        @if(isset($mainProf->price) && !empty($mainProf->price))
                                            <span class="price">от {{ $mainProf->price }}</span>
                                        @endif
                                        <div style="margin:10px 0">{{ $mainProf->description }}</div>
                                    </div>
                                    <div class="col-md-5">
                                        @if(Auth::check() && Auth::user()->id==$user->id)
                                            <a href="#create-album" class="fancybox btn-main" style="margin-bottom: 20px;">Создать новый альбом</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-5">
                            <div class="profile-data">    
                                    @if(!empty($userinfo->phone))
                                        <div class="col-md-12">
                                            <dt class="col-md-6">Мобильний телефон</dt>
                                            <dd class="col-md-6">{{ $userinfo->phone }}</dd>
                                        </div>
                                    @endif

                                    <div class="col-md-12">
                                        <dt class="col-md-6">E-mail</dt>
                                        <dd class="col-md-6" style="color:#665e83;margin-bottom:10px;">{{ $user->email }}</dd>
                                    </div>

                                        
                                    @if(!empty($userinfo->site))
                                        <div class="col-md-12">
                                            <dt class="col-md-6">Сайт</dt>
                                            <dd class="col-md-6" style="color:#665e83;margin-bottom:10px;">{{ $userinfo->site }}</dd>
                                        </div>
                                    @endif 

                                    @if(!empty($userinfo->birthday))
                                        <div class="col-md-12">
                                            <dt class="col-md-6">Дата рождения</dt>
                                            <dd class="col-md-6">{{ date('d-m-Y',$userinfo->birthday) }}</dd>
                                        </div>
                                    @endif

                                    @if(!empty($userinfo->gender))
                                        <div class="col-md-12">
                                            <dt class="col-md-6">Пол</dt>
                                            <dd class="col-md-6">{{ $userinfo->gender=='male'?'Мужской':':Женский' }}</dd>
                                        </div>
                                    @endif

                                    @if(!empty($userinfo->city))
                                        <div class="col-md-12">
                                            <dt class="col-md-6">Город</dt>
                                            <dd class="col-md-6">{{ $userinfo->city }}</dd>
                                        </div>
                                    @endif     

                                    <div class="col-md-12">
                                        <dt class="col-md-6">Просмотр профиля</dt>
                                        <dd class="col-md-6">{{ round($userinfo->enters_count) }}</dd>
                                    </div>

                                    <div class="col-md-12">
                                        <dt class="col-md-6">Лайков</dt>
                                        <dd class="col-md-6">{{ $likesCount }}</dd>
                                    </div>

                                    @if($userInfo->role_id!=2)
                                        <div class="col-md-12">
                                            <dt class="col-md-6">Выполненных заказов</dt>
                                            <dd class="col-md-6">{{ $projectsDoneCount }}</dd>
                                        </div>
                                    @endif

                                    <div class="col-md-12">
                                        <dt class="col-md-6">Регистрация на сайте</dt>
                                        <dd class="col-md-6">
                                            {{ Common_helper::getPastTime($user->created_at) }}
                                        </dd>
                                    </div>
                              
                                @if($userInfo->role_id!=2)
                                    <div class="col-md-12">
                                        <footer>
                                            <p>Выезжаю в другой город - <i class="fa {{ !empty($userinfo->city_departure)?'fa-check':'fa-times' }}"></i></p>
                                            <p>Выезжаю за рубеж - <i class="fa {{ !empty($userinfo->country_departure)?'fa-check':'fa-times' }}"></i></p>
                                        </footer>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(count($albums))
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
                            <div class="profile-info">
                                <h3>{{ $val->name }}</h3>
                                <span class="price">от {{ $val->price }}</span>
                                <p>{{ $val->description }}</p>
                                @if(Auth::check() && Auth::user()->id==$user->id)
                                    <a href="#create-album" class="fancybox btn-main" style="margin-bottom:20px">Создать новый альбом</a>
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