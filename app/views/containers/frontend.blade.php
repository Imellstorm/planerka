<!DOCTYPE html>
<html lang="en">
<head>

<title>@yield('title')</title>

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
    @section('styles')

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
    @section('scripts')
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
        });
    </script>
</head>
<body>

<!-- HEADER
    ============================= -->
    <header id="header" style="background: url(/assets/img/body_bg.png) no-repeat top center;   background-color: #726E68;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="header-content">
                        <div class="login">
                            <p>Что бы воспользоваться всеми преимуществами нашего портала пройдите быструю регистрацию или залогиньтесь !</p>
                            <div class="registration">
                                <a href="/auth">Вход</a>|<a href="#">Регистрация</a>
                            </div>
                        </div>

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
                                    <select id="select-categ" class="selectpicker">
                                        <option>Жанр Исполнителя</option>
                                        <option>Фотография</option>
                                        <option>Фотография</option>
                                    </select>
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
                            Автор Фото: <a href="#null">Светлана Огневич</a>
                        </div>
                        
                        <a href="#null" class="add_post">Добавить мероприятие</a>
                    </div>  
                </div>
            </div>
        </div>
    </header>

<!-- NAVMENU
    ============================= -->
    <nav id="nav-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="#null" class="show-menu"><span class="glyphicon glyphicon-align-justify"></span>MENU</a>
                    <ul class="menu">
                        <li>
                            <a href="/?search=true">Ведущий<br>Тамада</a>
                        </li>
                        <li>
                            <a href="/?search=true">Фотограф<br>Оператор</a>
                        </li>
                        <li>
                            <a href="/?search=true">Визажист<br>Стилист</a>
                        </li>
                        <li>
                            <a href="/?search=true">Артисты<br>Шоу</a>
                        </li>
                        <li>
                            <a href="/?search=true">Свадебные<br>блоги</a>
                        </li>
                        <li>
                            <a href="/?search=true">Оформление<br>свадьбы</a>
                        </li>
                        <li>
                            <a href="#null" id="sub-menu-show">Другое</a>
                            <ul class="sub-menu">
                                <li><a href="#null">Рестораны</a></li>
                                <li><a href="#null">Лимузины</a></li>
                                <li><a href="#null">Загсы</a></li>
                                <li><a href="#null">Свадебные платья</a></li>
                                <li><a href="#null">Свадебный регистратор</a></li>
                                <li><a href="#null">Обручальные кольца</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    @yield('main')

<!-- NAV FOOTER
    ============================= -->
    <nav class="nav-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul>
                        <li><a href="/faq">Частые вопросы</a></li>
                        <li><a href="/about">О проекте</a></li>
                        <li><a href="/contacts">Контакты</a></li>
                        <li><a href="/agreement">Пользовательское соглашение</a></li>
                        <li><a href="/rules">Правила</a></li>
                        <li><a href="/servises">Услуги</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

<!-- FOOTER
    ============================= -->
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <p>При использовании материалов  портала Planerka.ru ссылка на сайт первоисточник обязательна.</p>
                    <p>Copyright 2014 Planerka.ru Все права защищены</p>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="social">
                        <a href="#null" class="vkontakte"></a>
                        <a href="#null" class="odnoklasniki"></a>
                        <a href="#null" class="twitter"></a>
                        <a href="#null" class="facebook"></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
