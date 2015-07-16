<!DOCTYPE html>
<html lang="en">
<head>

<title>@yield('title')</title>
    <meta property="og:image" content="{{ URL::to('/').'/assets/img/user-logo.png' }}" />

<!-- Meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="#" />
    <meta name="keywords" content="#" />

<!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />

<!-- CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/checkbox.css">
    <link rel="stylesheet" href="/assets/css/fancybox.css">
    <link rel="stylesheet" href="/assets/css/datepicker.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.css">
    <link rel="stylesheet" href="/assets/css/fonts.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/media.css">
    @yield('styles')

<!-- JS -->
    <!-- <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>  -->
    <script type="text/javascript" src="/assets/js/modernizr.js"></script>
    <script type="text/javascript" src="/assets/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="/assets/js/jquery-ui-1.9.2.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="/assets/js/fancybox.js"></script>
    <script type="text/javascript" src="/assets/js/sticky.js"></script>
    <script type="text/javascript" src="/assets/js/maskedinput.js"></script>
    <script type="text/javascript" src="/assets/js/main.js"></script>
    @yield('scripts')
    <script>
        // var geocoder;
        // if (navigator.geolocation) {
        //     navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
        // } 

        // //Get the latitude and the longitude;
        // function successFunction(position) {
        //     var lat = position.coords.latitude;
        //     var lng = position.coords.longitude;
        //     codeLatLng(lat, lng)
        // }

        // function errorFunction(){
        //   //alert("Geocoder failed");
        // }

        // function initialize() {
        //     geocoder = new google.maps.Geocoder();
        // }

        // function codeLatLng(lat, lng) {
        //     var latlng = new google.maps.LatLng(lat, lng);
        //     geocoder.geocode({'latLng': latlng}, function(results, status) {
        //         if (status == google.maps.GeocoderStatus.OK) {
        //             if (results[0]) {
        //                 console.log(results[0]);
        //                 city = results[0].address_components[3]
        //                 $('.city-input').val(city.long_name);
        //             }
        //         }
        //     });
        // }

        function getBrowserInfo() {
            var t,v = undefined;
            if (window.chrome) t = 'Chrome';
            else if (window.opera) t = 'Opera';
            else if (document.all) {
                t = 'IE';
                var nv = navigator.appVersion;
                var s = nv.indexOf('MSIE')+5;
                v = nv.substring(s,s+1);
            }
            else if (navigator.appName) t = 'Netscape';
            return {type:t,version:v};
        }
        function bookmark(a){
            var url = window.document.location;
            var title = window.document.title;
            var b = getBrowserInfo();
            if (b.type == 'IE' && 8 >= b.version && b.version >= 4) window.external.AddFavorite(url,title);
            else if (b.type == 'Opera') {
                a.href = url;
                a.rel = "sidebar";
                a.title = url+','+title;
                return true;
            }
            else if (b.type == "Netscape") window.sidebar.addPanel(title,url,"");
            else alert("Нажмите CTRL-D, чтобы добавить страницу в закладки.");
            return false;
        }
        $(document).ready(function(){
            //  initialize();
            $(".phone").mask("+7 (999) 999-9999");

            @if (Session::has('message'))
                $.fancybox('{{ Session::get('message') }}',{helpers: {overlay: {locked: false} }});
            @endif

            @if(Session::has('token'))
                $('#fancybox_reset_password_btn').trigger('click');
            @endif

            @if(Session::has('socId') && Session::has('socNetwork'))
                $('#registration-button').trigger('click');
                $('.socNet').val('{{ Session::get('socNetwork') }}');
                $('.socId').val('{{ Session::get('socId') }}');
                $('.socImage').val('{{ Session::get('socImage') }}');
                $('.social-login').hide();
                $('.social-message').text('Вы авторизировались в {{ Session::get('socNetwork') }}. Для продолжения регистрации заполните недостающие поля.');
            @endif     
        });
    </script>
</head>
<body>

<a href="#fancybox_reset_password" class="fancybox" id="fancybox_reset_password_btn" style="display:none">link</a>

<!-- HEADER
    ============================= -->
    <header id="header" style="background: url('{{ isset($profile)&&isset($userInfo->cover)&&!empty($userInfo->cover)?'/'.$userInfo->cover:'/assets/img/body_bg.png' }}') no-repeat top center;   background-color: #726E68; background-size: 100%;">
    @if(Auth::check())           
        <div class="user-nav">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="logo"><a href="/"><img src="/assets/img/user-logo.png" alt=""></a></div>
                        
                        <div class="menu-panel">
                            <div class="list">
                                <a href="/project/list"><img src="/assets/img/paper.png" alt=""></a>
                            </div>
                            <div class="mail">
                                <a href="/account/messages"><img src="/assets/img/mail.png" alt=""></a>
                                @if(!empty($newMessages) || !empty($newProjectMessages) || !empty($newNotifications))
                                    <span>{{ $newMessages+$newProjectMessages+$newNotifications }}</span>
                                @endif
                            </div>
                            <div class="count">
                                <a href="/account/shop">{{ Auth::user()->balance }} руб.</a>
                            </div>
                            @if($userInfo->pro >= date('Y-m-d'))
                                <div class="status" style="margin: 7px 7px 0 10px;">PRO</div>
                            @endif
                            <div class="user" id="show-user-menu">
                                <div class="name">{{ Auth::user()->username }}</div>
                                <a href="#null"><img src="/assets/img/dropdown_icon.png" alt=""></a>
                                <ul id="user-menu">
                                    @if(Auth::user()->role->id==1)
                                        <li><a href="/admin/users">Админпанель</a></li>
                                    @endif
                                    <li><a href="/account/messages">Сообщения</a></li>
                                    <li><a href="/account/favorites">Избранное</a></li>
                                    <li><a href="/account/projects">Заказы / уведомления</a></li>
                                    <li><a href="/{{ Auth::user()->alias }}">Профиль</a></li>
                                    <li><a href="/account/info">Настройки</a></li>
                                    <li><a href="/auth/logout">Выход</a></li>
                                </ul>
                            </div>
                            <div class="avatar">
                                <a href="/{{ Auth::user()->alias }}">    
                                    <img src="{{ Common_helper::getUserAvatar(Auth::user()->id) }}" alt="" style="width:48px;height:48px;">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
        <div class="container">
            <div class="row">
            
                @if(!Auth::check())
                    <div class="login">
                        <p>Что бы воспользоваться всеми преимуществами нашего портала пройдите быструю регистрацию или залогиньтесь !</p>
                        <div class="registration">
                            <a href="/auth/showloginform" class="fancybox_ajax">Вход</a>|<a href="#modal-register" class="fancybox" id="registration-button">Регистрация</a>
                        </div>
                    </div>
                @endif

                @if(isset($profile))
                    <div class="col-sm-5" style="margin:100px 0 20px 0">
                        <div class="pers-info">
                            <div class="avatar"><img src="{{ Common_helper::getUserAvatar($userInfo->user_id) }}" alt=""></div>
                            <div class="top-cont">
                                @if(!empty($userInfo->name) || !empty($userInfo->surname))
                                    <div class="name">{{ $userInfo->name.' '.$userInfo->surname }}</div>
                                @else
                                    <div class="name">{{ $userInfo->alias }}</div>
                                @endif
                                <div class="{{ $user->online?'online':'offline' }}" style="margin-top:10px;"></div>
                                @if($userInfo->pro >= date('Y-m-d'))
                                    <div class="status" style="margin: 7px 7px 0 10px;">PRO</div>
                                @endif
                            </div>
                            <div class="bott-cont">
                                <div class="place">{{ $userInfo->city }}</div>
                                @if($user->role_id!=2)
                                    <div class="order-count">Выполнено заказов:&nbsp;&nbsp; {{ $projectsDoneCount }}</div>
                                @endif
                                <div class="rait">Рейтинг:&nbsp;&nbsp; 452.2</div>
                            </div>
                        </div>
                        @if(count($userInfo->profs))
                            <ul class="price">
                                @foreach($userInfo->profs as $prof)
                                    <li>{{ $prof->name }} от {{ $prof->price }} р.</li>
                                @endforeach
                            </ul>
                        @endif
                        @if($userInfo->role_id==2)
                            <ul class="price">
                                <li>Заказчик</li>
                            </ul>
                        @endif
                        <div class="msg">
                            {{ $userInfo->biography }}
                        </div>
                        @if(Auth::check() && $userInfo->user_id!=Auth::user()->id)                 
                            <div class="star">
                                @if(!$favoriteExist)
                                    <a href="/favorites/save/{{ $userInfo->alias }}">
                                        <img src="/assets/img/star.png" title="Добавить в избранное">
                                    </a>
                                @else
                                    <a href="/favorites/delete/{{ $favoriteExist }}">
                                        <img src="/assets/img/star_nocolor.png" title="Убрать из избранного">
                                    </a>
                                @endif
                            </div>
                            <a href="/message/create/{{ $userInfo->user_id }}" class="btn-main fancybox_ajax_scroll">Отправить сообщение</a>
                            @if(Auth::user()->role_id==2 && $userInfo->role_id!=2)
                                    <br><br><br>
                                    <a href="/project/inviteperformer/{{ $user->id }}" class="btn-main fancybox_ajax" style="width:120px; margin-left:52px;">Заказать</a>
                                
                            @endif
                        @endif
                    </div>
                @else
                <div class="col-sm-12">
                    <div class="header-content" style="padding-top:{{ Auth::check()?'60px':'' }}">

                        <div class="logo">
                            <a href="/"><img src="/assets/img/logo.png" alt=""></a>
                        </div>

                        <div class="text-banner">
                            Найдите лучшего исполнителя на ваше мероприятие <br> с <span>Planerka</span> - это легко :
                        </div>

                        <div class="search">
                            <div class="mobile-title">
                                <a href="#null">Поиск мероприятия</a><span class='glyphicon glyphicon-search'></span>
                            </div>
                            {{ Form::open(array('role' => 'form', 'url' => '/search', 'class'=>'form-inline', 'method'=>'get')) }}
                                <div class="form-group categ">
                                    @if(!empty($roles))
                                    <select id="select-categ" class="selectpicker" name="specialization">
                                        <option value="0">Все специализации</option>
                                        @foreach($roles as $key=>$val)
                                            <option value="{{ $val }}">{{ $key }}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Город" name="city" id="city_search" class="form-control city-input" style="width:180px">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="datepicker" name="date" placeholder="Дата" class="form-control">
                                </div>
                                <div class="form-group paym">
                                    <select id="select-theme" class="selectpicker" name="budjet">
                                        <option value="0">Бюджет</option>
                                        <option value="1">От 0 до 1000 руб.</option>
                                        <option value="2">От 1000 до 3000 руб.</option>
                                        <option value="3">От 3000 до ...</option>
                                    </select>
                                </div>
                                <div class="form-group search-area">
                                    <button class="btn btn-search">Поиск</button>
                                </div>
                            {{ Form::close() }}
                        </div>

                        <div class="author-photo">
                            @if(isset($cover)&&!empty($cover->author))
                                Автор Фото: <a href="#null">{{ isset($cover)&&!empty($cover->author)?$cover->author:'' }}</a>
                            @endif
                        </div>
                        @if(Auth::check() && Auth::user()->role_id == 2)
                            <a href="/project/create" class="add_post fancybox_ajax">Добавить мероприятие</a>
                        @endif
                    </div>  
                </div>
                @endif
            </div>
        </div>
    </header>

<!-- NAVMENU
    ============================= -->
    <nav id="nav-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12 top_menu">
                    <a href="#null" class="show-menu"><span class="glyphicon glyphicon-align-justify"></span>MENU</a>
                    {{ $menu->top }}
                    <img src="/assets/img/dropdown_icon.png" style="margin: -5px 0 0 30px;">
                    <script>           
                        $(".menu:first>li>a").width(function(i,val){
                            $(this).css('width',val-val*0.48);
                        });                 
                    </script>
                </div>
            </div>
        </div>
    </nav>

    @if ($errors->has())
        @foreach ($errors->all() as $error)
            <div class='bg-danger alert text-center'>
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                {{ $error }}
            </div>
        @endforeach
    @endif

    @yield('main')

    @if(!Auth::check())
        @include('content.front.modals')
    @endif

<!-- NAV FOOTER
    ============================= -->
    <nav class="nav-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {{ $menu->bottom }}
                </div>
            </div>
        </div>
    </nav>

<!-- FOOTER
    ============================= -->
    <footer id="footer">
        <div class="container">
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-12" style="margin-bottom:20px;">
                    <p>Наши партнёры:</p>
                    <div class="col-md-12">
                        <a href="http://seaflats.ru"><img src="/assets/img/morekvartir.png"></a>
                        <a href="http://openfrag.ru"><img src="/assets/img/openfrag.png"></a>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12">
                    <p>При использовании материалов  портала Planerka.ru ссылка на сайт первоисточник обязательна.</p>
                    <p>Copyright 2014 Planerka.ru Все права защищены</p>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="social">
                        <a href="https://instagram.com/planercaru" class="instagram"></a>
                        <a href="http://vk.com/planercaru" class="vkontakte"></a>
                        <a href="#null" class="twitter" style="display:none"></a>
                        <a href="#null" class="facebook" style="display:none"></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
