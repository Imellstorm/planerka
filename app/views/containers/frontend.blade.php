<!DOCTYPE html>
<html lang="en">
<head>

<title>@yield('title')</title>
    <meta property="og:image" content="{{ urlencode(URL::to('/').'/assets/img/user-logo.png') }}" />

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
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script> 
    <script type="text/javascript" src="/assets/js/modernizr.js"></script>
    <script type="text/javascript" src="/assets/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="/assets/js/jquery-ui-1.9.2.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="/assets/js/fancybox.js"></script>
    <script type="text/javascript" src="/assets/js/sticky.js"></script>
    <script type="text/javascript" src="/assets/js/main.js"></script>
    @yield('scripts')
    <script>
        var geocoder;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
        } 
        //Get the latitude and the longitude;
        function successFunction(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            codeLatLng(lat, lng)
        }
        function errorFunction(){
          alert("Geocoder failed");
        }
        function initialize() {
            geocoder = new google.maps.Geocoder();
        }
        function codeLatLng(lat, lng) {
            var latlng = new google.maps.LatLng(lat, lng);
            geocoder.geocode({'latLng': latlng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    //console.log(results)
                    if (results[1]) {
                        //formatted address
                        //alert(results[0].formatted_address)
                        //find country name
                        for (var i=0; i<results[0].address_components.length; i++) {
                        for (var b=0;b<results[0].address_components[i].types.length;b++) {
                            //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                                if (results[0].address_components[i].types[b] == "administrative_area_level_2") {
                                    //this is the object you are looking for
                                    city= results[0].address_components[i];
                                    break;
                                }
                            }
                        }
                        //city data
                        //alert("Местоположение "+city.short_name + " " + city.long_name)
                        $('.city-input').val(city.long_name);
                    }
                }
            });
        }

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
            initialize();

            @if (Session::has('message'))
                $.fancybox('{{ Session::get('message') }}');
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
    <header id="header" style="background: url('{{ isset($userInfo)&&!empty($userInfo)?'/'.$userInfo->cover:'/assets/img/body_bg.png' }}') no-repeat top center;   background-color: #726E68;">
    @if(Auth::check())           
        <div class="user-nav">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="logo"><a href="/"><img src="/assets/img/user-logo.png" alt=""></a></div>
                        
                        <div class="menu-panel">
                            <div class="list"><a href="#null"><img src="/assets/img/paper.png" alt=""></a></div>
                            <div class="mail"><a href="/account/messages"><img src="/assets/img/mail.png" alt=""></a><span>1</span></div>
                            <div class="count">
                                <a href="/account/shop">{{ Auth::user()->balance }} руб.</a>
                            </div>
                            <div class="status">PRO</div>
                            <div class="user" id="show-user-menu">
                                <div class="name">{{ Auth::user()->username }}</div>
                                <a href="#null"><img src="/assets/img/dropdown_icon.png" alt=""></a>
                                <ul id="user-menu">
                                    @if(Auth::user()->role->id==1)
                                        <li><a href="/admin/users">Админпанель</a></li>
                                    @endif
                                    <li><a href="/account/messages">Сообщения</a></li>
                                    <li><a href="/account/favorites">Избранное</a></li>
                                    <li><a href="/account/orders">Заказы / уведомления</a></li>
                                    <li><a href="/{{ Auth::user()->alias }}/photo">Профиль</a></li>
                                    <li><a href="/account/info">Настройки</a></li>
                                    <li><a href="/auth/logout">Выход</a></li>
                                </ul>
                                <div class="avatar"><img src="{{ Common_helper::getUserAvatar(Auth::user()->id) }}" alt="" style="width:48px;height:48px;"></div>
                            </div>
                            <a href="#null" class="download">Загрузить</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
        <div class="container">
            <div class="row">
                @if(isset($userInfo)&&!empty($userInfo))
                    <div class="col-sm-5" style="margin:100px 0 20px 0">
                        <div class="pers-info">
                            <div class="avatar"><img src="{{ Common_helper::getUserAvatar($userInfo->user_id) }}" alt=""></div>
                            <div class="top-cont">
                                <div class="name">{{ $userInfo->name.' '.$userInfo->surname }}</div>
                                <div class="online"></div>
                                <div class="status">PRO</div>
                            </div>
                            <div class="bott-cont">
                                <div class="place">{{ $userInfo->city }}</div>
                                <div class="order-count">Выполнено заказов:&nbsp;&nbsp; 22</div>
                                <div class="rait">Рейтинг:&nbsp;&nbsp; 452.2</div>
                            </div>
                        </div>
                        @if(!empty($userInfo->profs))
                            <ul class="price">
                                @foreach($userInfo->profs as $prof)
                                    <li>{{ $prof->name }} от {{ $prof->price }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="msg">
                            {{ $userInfo->biography }}
                        </div>
                        <div class="star"><img src="/assets/img/star.png" alt=""></div>
                        <a href="#null" class="btn-main">Отправить сообщение</a>
                    </div>
                @else
                <div class="col-sm-12">
                    <div class="header-content" style="padding-top:{{ Auth::check()?'60px':'' }}">
                        @if(!Auth::check())
                            <div class="login">
                                <p>Что бы воспользоваться всеми преимуществами нашего портала пройдите быструю регистрацию или залогиньтесь !</p>
                                <div class="registration">
                                    <a href="#modal-login" class="fancybox">Вход</a>|<a href="#modal-register" class="fancybox" id="registration-button">Регистрация</a>
                                </div>
                            </div>
                        @endif
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
                            <form class="form-inline" role="form" method="get">
                                <input type="hidden" name="search" value="true">
                                <div class="form-group categ">
                                    @if(!empty($roles))
                                    <select id="select-categ" class="selectpicker">
                                        <option value="0">Жанр исполнителя</option>
                                        @foreach($roles as $key=>$val)
                                            <option value="{{ $val }}">{{ $key }}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                                <div class="form-group theme">
                                    <select id="select-theme" class="selectpicker">
                                        <option>Тема</option>
                                        <option>Тема 1</option>
                                        <option>Тема 2</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Город" class="form-control city-input">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="datepicker" placeholder="Дата" class="form-control">
                                </div>
                                <div class="form-group paym">
                                    <select id="select-theme" class="selectpicker">
                                        <option>Бюджет</option>
                                        <option>От 0 до 1000 руб.</option>
                                        <option>От 1000 до 3000 руб.</option>
                                        <option>От 3000 до ...</option>
                                    </select>
                                </div>
                                <div class="form-group search-area">
                                    <button class="btn btn-search">Поиск</button>
                                </div>
                            </form> 
                        </div>

                        <div class="author-photo">
                            @if(isset($cover)&&!empty($cover->author))
                                Автор Фото: <a href="#null">{{ isset($cover)&&!empty($cover->author)?$cover->author:'' }}</a>
                            @endif
                        </div>
                        @if(Auth::check() && Auth::user()->role_id == 2)
                            <a href="#null" class="add_post">Добавить мероприятие</a>
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
